<template>
    <ul>
        <li class="left clearfix" v-for="title in titles">
            {{ title }}
        </li>
    </ul>
</template>

<script>
export default {
  props: ['titles']
};
</script>