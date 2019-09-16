<template>
    <layout>
        <div class="h-full flex items-center justify-center text-gray-800">
            <h1
                class="text-right text-6xl pr-2 mr-2 border-r-2 border-gray-500"
            >
                {{ code }}
            </h1>
            <p class="max-w-sm text-left text-2xl">
                {{ message }}
            </p>
        </div>
    </layout>
</template>

<script>
import Layout from "./Layout/Main";

export default {
    name: "Error",

    metaInfo() {
        return {
            title: `${this.code}`,
            meta: [
                {
                    vmid: "description",
                    name: "description",
                    content:
                        "It looks like you reached a dark place. Please get back immediately."
                }
            ]
        };
    },

    components: {
        Layout
    },

    props: {
        code: {
            type: Number,
            default: 404
        },
        message: {
            type: String,
            default: "Resource not found."
        }
    }
};
</script>
