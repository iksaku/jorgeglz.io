---
layout: '../_layout.astro'
title: 'Setting up Laravel applications with Caddy 2'
description: 'Managing web servers can be kind of tricky, and with an increasing number of applications in one server, managing all of their configuration files can start to feel like a burden...'
date: '2020-10-08'
---

Managing web servers can be kind of tricky, and with an increasing number of
applications in one server, managing all of their configuration files can start
to feel like a burden 🥴.

Maybe just my point of view, maybe not at all...

<!-- more -->

In the last few days, I started looking for a way to migrate from Nginx to a
Caddy web server for all my Laravel applications, just because of two things:

1. Caddy is HTTPS-first, so I don’t need to worry about certbot trying to renew
domains that are no longer available in my private server, nor failing to
manage recently added domains that I forgot to tell certbot about. Caddy
manages this for me automatically 💖.
2. Caddy’s configuration files are way easier to understand than Nginx’s, even
without previous knowledge of the properties of a `Caddyfile`, you can easily
grasp what a config file is doing just by reading it.

Surprisingly to me, [Caddy just got its v2 upgrade](https://caddyserver.com/v2)
a few months ago, which is full of new awesome features, and the cherry of the
cake for me is that their traditional `Caddyfiles` just got way easier to read!
So much was **done right** for this update!

Also surprising to me was the lack of Laravel templates available for Caddy 2,
which is not a big deal, but I hoped to find a good template as a starting point
after all these months that Caddy 2 has been available.

Instead, I found
[Mattias’ Laravel template for Caddy v1](https://ma.ttias.be/caddyfile-config-example-for-laravel/)
(thanks Mattias!), which seemed pretty solid to me, so I saved a copy and
started to work 👨‍💻.

## Getting Started with Caddy

First, you need to install Caddy on your server (obviously), you can find a
pretty detailed guide on [Caddy’s Documentation](https://caddyserver.com/docs/).
So just go and surf the documentation before coming back.

## PHP + Caddy = ❤️

So, managing PHP applications with Caddy is dead simple, and even Laravel is a
**dead simple** framework for PHP, so a pretty good match can come out of this
👀.

Let’s take a moment and think of what we need to tell Caddy about our Laravel
application:

1. It should use HTTPS.
2. It should serve static files if possible.
3. If no static files are found, then it should properly route incoming requests
to PHP-FPM.

Well, this seems like a good starting point. So, I present to you the Caddy 2
template I use for Laravel:

```
my-website.com {
    # Resolve the root directory for the app
    root * /var/www/my-website/public

    # Provide Zstd and Gzip compression
    encode zstd gzip

    # Allow caddy to serve static files
    file_server

    # Enable PHP-FPM
    php_fastcgi unix//run/php/php7.4-fpm.sock
}
```

> A fun thing about this is that Caddy does support the _Zstd Compression
> Algorithm_, however, no browsers actually support it. Anyhow, supported
> algorithms are requested from the client, so we're prepared for the time when
> browsers start supporting zstd.

As you can see, integrating Laravel with Caddy is dead simple. Just define the
root directory, present our PHP-FPM socket to Caddy and finally tell Caddy to
serve static files when possible.

But wait... What about HTTPS? Where do I define port 443? How do I configure my
_Let’s Encrypt_ SSL certificates? Well... **SURPRISE!!!** Caddy automatically
handles SSL certificates for you! 😍. No need to define port 443, no
need to have a folder with certificates, all is handled automatically by Caddy,
and it’s internal Let’s Encrypt integration 🥳.

Up to this point, everything should be OK for you, you can start copy-pasting
this template for all your websites! 🚀

## Let's make this easier...

Okay, hold on a sec... Didn't I say that it is a burden to manage multiple
configuration files? Yeah, I did... But we can actually abstract this template
into a [Caddy Snippet](https://caddyserver.com/docs/caddyfile/concepts#snippets)
which can help us to re-use this template without copy-pasting anything!

Supposing that you're interested enough, I hope you already took a look at the
link above, if not, go check it out!

Now, back to our snippet... In my setup, I have a `/etc/caddy/snippets/`
directory where I place all my snippets, so I can easily import them beforehand:

```
# Caddyfile
import snippets/*
```

And that's it, all available snippets in the directory will be available for us,
now, we can create our `laravel-app` snippet:

```
# snippets/laravel-app
# {args.0} represents the root url of the app. Example: "jorgeglz.io".
# {args.1} represents the root path to the app. Example: "/var/www/my-site.com"

(laravel-app) {
    {args.0} {
        # Resolve the root directory for the app
        root * {args.1}/public

        # Provide Zstd and Gzip compression
        encode zstd gzip

        # Enable PHP-FPM
        php_fastcgi unix//run/php/php7.4-fpm.sock

        # Allow caddy to serve static files
        file_server
    }
}
```

Cool! Now we can start referencing this snippet for all our Laravel apps:

```
import snippets/*

# Use the "laravel-app" snippet for our site:
import laravel-app my-site.com /var/www/my-site.com
```

And with this, we're good to go! ⚡

Just beware that modifying the snippet will update the configuration for all
your applications, so keep it as simple as you can 😉.
