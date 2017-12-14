<template>
    <div class="jumbotron">
        <h1 :class="hClass" v-if="header">{{ headerContent }}</h1>
        <slot name="body"></slot>
    </div>
</template>

<script>
    export default {
    	props:[
            'use-header',
            'header-content',
            'header-class'
        ],
    	data() {
    		return {
                'header': (this.useHeader == 'true'),
                'hClass': this.headerClass 
    		}
    	},
    	methods: {
            
    	},
        mounted() {

        }
    }
</script>