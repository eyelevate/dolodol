<template>
	<div class="progress progress-xs mt-1 mb-0">
        <div class="progress-bar" :class="colorClass" role="progressbar" :style="styleObject" :aria-valuenow="valueNow" :aria-valuemin="valueMin" :aria-valuemax="valueMax"></div>
    </div>
    

</template>

<script>
    export default {
    	props:['min','max', 'current', 'color-class'],

    	data() {
    		return {
                valueNow: this.current,
                valueMin: this.min,
                valueMax: this.max,
                styleObject: {
                    width: this.current+'%'
                }
    		}
    	},
        mounted() {

        }
    }
</script>