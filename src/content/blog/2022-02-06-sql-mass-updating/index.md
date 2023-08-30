---
slug: sql-mass-updating
title: Updating multiple database records (with independent data) in a single query
description: Sounds crazy, right? Well, it is possible, and I can tell you how 😉
date: 2022-02-06
---

In the world of SQL Databases, it is pretty easy to update one or many records
in a table, you just need to execute an `UPDATE` query with some column-value
bindings and some filters if needed, this will help you either update single
record, or update many records with the same data.

But what if we want to update many records with independent data? 🤔

## 1. The Project

Let's imagine we have a project where we keep track of the following customer
data:

- Name
- Birthday

And our project as an API that allows us to perform basic CRUD operations over
such data, but let's focus on an easy to consume `update` endpoint:

```http
POST /api/customers/{id}
Content-Type: application/json

{
  "name": "<Insert name>",
  "birthday": "<Insert birthday>"
}
```

When implementing this server-side, we could use the following SQL query to
update our record:

```sql
UPDATE "customers"
SET "name" = :name, "birthday" = :birthday
WHERE "id" = :id
```

Where `:id` would be extracted from the endpoint route, and `:name` and
`:birthday` from the request body.

## 2. The issue

With our imaginary project deployed, there comes a necessity to update the
information of many customers in a single call, and while the _end
client_ could just fire many API calls, it is not desirable due to the
unnecessary resource consumption of processing many API calls, and the latency
between our servers and the client sending such API requests.

To solve this issue, we introduce an `batch` endpoint under our `update`
endpoint, which will allow our API to resolve the data of many customers in a
single API request:

```http
POST /api/update/batch
Content-Type: application/json

{
  "<id>": {
    "name": "...",
    "birthday": "...",
  },
  //...
}
```

This way, we could just iterate over the values of the request and fire up the
necessary `UPDATE` queries to update our records in our database:

```php
foreach ($request_data as $id => $data) {
  DB::table('customers')
    ->where('id', '=', $id)
    ->update($data)
}

// PS: Don't forget to sanitize your data!
```

With this, we can update the data of many customers in a single API call, while
keeping the data for each customer scoped, and we can even filter our columns
that are not updated, so our database only processes the information that was
actually requested to be updated.

Problem solved, right? ✨

Well... we just missed one little detail...

As you may already know, firing multiple database queries adds up in waiting
time before your server can return a response to the end client, and when
performing bulk actions in a single call, the response time increases according
to the number of queries you need to execute, the complexity, and the latency
between your API and the Database ⏳.

So, for small sets of data, this is not a problem, but what if, suddenly, our
administrators need to update the information of ~1k customers? The response may
not be that fast as when we were only batching 5 customers for updates.

## 3. Multiple records, with independent data, in a single query

We need to optimize the way our `batch` endpoint works, but how? There's no
query available in our SQL database that can handle the update of many records
with individual sets of data, and let's not talk about dynamically selecting
columns to update... We can only:

- `UPDATE` each record individually, with its own column-value bindings, or
- `UPDATE` all records, setting the same value for all the columns.

In order to achieve this, we can make use of the `CASE` SQL statement, which
combined with the `UPDATE` statement, can open the doors to:

1. Update multiple records.
2. Each with independent column-value bindings.
3. In a single query.

Interesting, right? 💡 Well, let's see how the actual query may look like:

```sql
UPDATE "customers"
SET
    "name" = CASE
        WHEN "id" = :id_1 THEN :name_1
        WHEN "id" = :id_2 THEN :name_2
        /* ... */
        WHEN "id" = :id_n THEN :name_n
        ELSE "id" /* If current record's id is not the statement list, then fallback to it's own value */
    END,
    "birthday" = CASE
        WHEN "id" = :id_1 THEN :birthday_1
        WHEN "id" = :id_2 THEN :birthday_2
        /* ... */
        WHEN "id" = :id_n THEN :birthday_n
        ELSE "id" /* If current record's id is not the statement list, then fallback to it's own value */
    END
WHERE "id" in :ids
```

The bindings for this list should be recollected beforehand in order to build
the query properly, and when properly implemented, this pattern can not only
help you optimize your `batch` API endpoint, it could also help in situations
where:

- You need to update many items conditionally when deploying a new version of
  your project.
- When you are working with an ORM and you need to "save" the changes of many
  models at once.

Hope you like this little, but spicy, SQL trick 🌶.

## Bonus: Laravel Mass-Update Package

You may not be aware, but I'm actually a huge Laravel fan, and so, I couldn't
miss the opportunity to build a package which wraps the implementation details
on this post into an easy to use model trait. It is called
[Laravel Mass-Update](https://github.com/iksaku/laravel-mass-update).

If you're not into Laravel or PHP, you can simply check out the source code of
this package and port it to your framework, ORM or language of choice.

If you're into Laravel, well, this package is pretty easy to set up, just:

1. Install the package: `composer install iksaku/laravel-mass-update`
2. Import the trait into your model of choice:

```php
use Illuminate\Database\Eloquent\Model;
use Iksaku\Laravel\MassUpdate\MassUpdatable;

class Customer extends Model
{
    use MassUpdatable;

    // ...
}
```

3. Make use of it's scoped `massUpdate()` method:

```php
Customer::query()->massUpdate(values: [...], uniqueBy: [...]);
```

Please take some time to read the
[package's README](https://github.com/iksaku/laravel-mass-update#readme) to see
some potential use cases in which you may use this query.
