<template>
    <div v-if="visible" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold">{{ title }}</h2>
            <p class="mt-4">{{ message }}</p>
            <div class="mt-4 text-right">
                <button @click="close" class="bg-blue-500 text-white px-4 py-2 rounded">Close</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Modal",
    props: {
        title: {
            type: String,
            required: true,
        },
        message: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            visible: false,
        };
    },
    methods: {
        open() {
            this.visible = true;
        },
        close() {
            this.visible = false;
        },
    },
};
</script>

<style scoped>
/* You can add more styles for your modal here */
</style>