<template>
	<div>
		<div class="input-group form-group-no-border">
	        <span class="input-group-addon" v-if="uIconPre">
                <i class="ion" :class="iconPre" style="position:relative; right:7px;"></i>
            </span>
	        <input id="" :placeholder="bPlaceholder" :type="ty" class="form-control" :name="nm" :value="old" required autofocus>
            <span class="input-group-addon" v-if="uIconPost">
                <i class="ion" :class="iconPost"></i>
            </span>
	    </div>  
	    <div class="col-12" v-if="err">
	        <small class="help-block">{{ bError }}</small>
	    </div>	
	</div>
    

</template>

<script>
    export default {
    	props:[
            'use-icon-pre',
            'use-icon-post',
            'b-icon-pre',
            'b-icon-post',
            'b-placeholder',
            'b-name',
            'b-value',
            'b-value',
            'b-error',
            'b-err',
            'b-type'
        ],
    	data() {
    		return {
    			err: this.bError,
    			ph: this.bPlaceholder,
    			ty: this.bType,
    			nm: this.bName,
    			old: this.bValue,
                uIconPre: (this.useIconPre == "true"),
                uIconPost: (this.useIconPost == "true"),
                iconPre: this.bIconPre,
                iconPost: this.bIconPost,
    		}
    	},
        mounted() {

        }
    }
</script>