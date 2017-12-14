<template>
	<div class = "form-group">
        <label v-if="uLabel">{{label}}</label>
        <div class="input-group" >
            <div class="input-group-addon" v-if="uIconPre">
                <i class="ion" :class="iconPre" style="padding-right:3px; font-size:20px;"></i>
            </div>
            <input 
                :id="uId" 
                :placeholder="bPlaceholder" 
                :type="ty" 
                class="form-control col-12" 
                :name="nm" 
                :value="old" 
                autofocus>
            <div class="input-group-addon" v-if="uIconPost">
                <i class="ion" :class="iconPost" style=""></i>
            </div>
        </div>
        <span class="help-block text-danger form-control-feedback" v-if="err">
            <small>{{ bError }}</small>
        </span> 
	</div>
    

</template>

<script>
    export default {
    	props:['b-icon-pre','b-icon-post','b-placeholder','b-name','b-value','b-value','b-error','b-err','b-type', 'use-icon-pre', 'use-icon-post', 'use-label', 'label','b-input-id'],

    	data() {
    		return {
    			err: this.bError,
    			iconPre: this.bIconPre,
                iconPost: this.bIconPost,
    			ph: this.bPlaceholder,
    			ty: this.bType,
    			nm: this.bName,
    			old: this.bValue,
                uIconPre: (this.useIconPre == "true"),
                uIconPost: (this.useIconPost == "true"),
                uLabel: (this.useLabel == "true"),
                uId:this.bInputId,
    		}
    	},
        mounted() {

        }
    }
</script>