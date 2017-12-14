<template>
    <div >
        <label v-if="uLabel">{{ label }}</label>
        <div class="row-fluid">
            <label class="switch switch-text" :class="sClass" >
                <input id="switch-input-on" :name="iName" type="checkbox" class="switch-input" v-if="iChecked" checked @click="applied(onChecked)">
                <input id="switch-input-off" :name="iName" type="checkbox" class="switch-input" v-else @click="applied(onChecked)">
                <span class="switch-label" data-on="Yes" data-off="No" ></span>
                <span class="switch-handle"></span>
            </label>    

        </div>

    </div>


</template>

<script>
    export default {
    	props:['use-label', 'label','input-name','input-checked','switch-type','switch-color'],

    	data() {
    		return {
                onChecked: (this.inputChecked == "true") ? "on" : "off",
                iChecked: (this.inputChecked == "true"),
                iName: this.inputName,
                uLabel: (this.useLabel == "true"),
                sClass: [
                    this.switchType,
                    this.switchColor
                ]
    		}
    	},
        methods: {
            applied(checked) {
                this.onChecked = (checked == "on") ? "off" : "on";
                console.log(this.onChecked);
                this.$emit('applied',this.onChecked);
            }
            
        },
        mounted() {

        }
    }
</script>