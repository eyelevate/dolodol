<template>
    <div class="card no-borders text-center">
    	<div>
    		<!-- <slot name=""></slot> -->
    		<slot name="header"></slot>
    	</div>
    	
	    <div class="card-block featured-inventory-item-body" :class="bClass">
	        <p>{{ title }}</p>
	    </div>
<!-- 	    <div class="card-footer featured-inventory-item-footer" :class="fClass" >
	    	<label>{{ desc }}</label>
	    </div> -->
	</div>
</template>

<script>
    export default {
    	props:[
            'body-class',
            'footer-class', 
            'header-class',
            'img-top-class',
            'title',
            'desc'
        ],
    	data() {
    		return {
    			bClass: this.bodyClass,
    			fClass: this.footerClass,
                hClass: this.headerClass,
                iTopSrc: this.imgTopSrc,
                iTopClass: this.imgTopClass
    		}
    	},
    	methods: {

    	},
        mounted() {

        }
    }
</script>