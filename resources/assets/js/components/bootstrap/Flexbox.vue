<template>
    <div class="flexbox">
        <h1 class="flexboxClass ">{{headerContent}} </h1>
      
        <slot name="body"></slot>  
      
    </div>


   
</template>

<script>
    export default {
    	props:[
           'flex-class'
        ],
    	data() {
    		return {
                'flexboxClass': this.flexClass 
    		}
    	},
    	methods: {
            
    	},
        mounted() {

        }
    }
</script>