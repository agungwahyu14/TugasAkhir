<template>
    
</template>

<script>
export default {
    name: 'Pagination',
    props: {
        onPreviousClick: {
            type: Function,
            required: true
        },
        onPageClick: {
            type: Function,
            required: true
        },
        onLastPageClick: {
            type: Function,
            required: true
        },
        onNextClick: {
            type: Function,
            required: true
        }
    }
};
</script>
