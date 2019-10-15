<template>
    <div class="min-h-screen h-full w-full flex flex-col">
        <app-header />

        <div class="h-full w-full flex-1">
            <div class="h-full container mx-auto p-4">
                <slot />
            </div>
        </div>

        <app-footer />
    </div>
</template>

<script>
import AppHeader from "./AppHeader";
import AppFooter from "./AppFooter";

export default {
    name: "Main",

    components: {
        AppHeader,
        AppFooter
    },

    metaInfo: {
        titleTemplate: "%s | JorgeGlz"
    }
};
</script>
