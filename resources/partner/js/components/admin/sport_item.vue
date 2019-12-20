<template>
    <tr >
        <td>{{this.sport_item.id}}</td>
        <td contentEditable="true">
            {{this.sport_item.import_id}}
        </td>
        <td contentEditable="true"  @input="updateName">
            {{this.sport_item.name}}
        </td>
        <td contentEditable="true" @input="updateLink">
            {{this.sport_item.link}}
        </td>
        <td contentEditable="true" @input="updateIcon">
            {{this.sport_item.icon}}
        </td>
        <td>
            <input type="color" :value="this.sport_item.color" @change="updateColor($event)">
        </td>
        <td>
            <div class="switch">
                <label><input type="checkbox" v-model="sport_item.is_active"><span class="lever"></span></label>
            </div>
        </td>
        <td>
            <div @click="UpdateItem" style="cursor: pointer"><i class="material-icons">save</i></div>
        </td>
    </tr>
</template>
<script>
    export default {
        data() {
            return {
                sport_item:[]
            }
        },
        props: [
            'data'
        ],
        mounted() {
            this.$nextTick(function () {

            })
        },
        methods:{
            UpdateItem(){
                console.log('item-----',this.sport_item);
                this.sport_item.is_active=this.sport_item.is_active.toString();
                console.log('item1-----',this.sport_item);
                var send_data={};
                send_data.type= 'update';
                send_data.table_name= 'sport_names';
                send_data.data=[];
                send_data.data=this.sport_item;
                send_data.condition=[];
                send_data.condition.push(['id',this.sport_item.id]);
                window.axios.post('/api/table_edit', {parameter:JSON.stringify(send_data)}).then(({ data }) => {
                    console.log(data.message);
                    showNotification('alert-success',data.message,'top','right','animated fadeInRight','animated fadeOutRight');
                });
            },
            updateName(event){
                this.sport_item.name=event.target.innerText;
                console.log('update-----',event.target.innerText);
            },
            updateLink(event){
                this.sport_item.link=event.target.innerText;
                console.log('update-----',event.target.innerText);
            },
            updateIcon(event){
                this.sport_item.icon=event.target.innerText;
                console.log('update-----',event.target.innerText);
            },
            updateColor(event){
                this.sport_item.color=event.target.value;
                console.log(this.sport_item.color);
            }
        },
        created() {
            this.sport_item=this.data;
            this.sport_item.is_active = (this.sport_item.is_active === 'true');

            console.log(this.sport_item);
        },
        components: {

        },
        watch: {
            mute(val) {
                document.getElementById('mute').className = val ? "on" : "";
            }
        },
    }
</script>