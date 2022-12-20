<template xmlns="http://www.w3.org/1999/html">
    <div class="w-full px-5 flex flex-col justify-between">
        <div class="flex flex-col mt-5">
            <div class="flex justify-end mb-4" v-for="message in messagess">
                <div
                    class="mr-2 py-3 px-4 bg-blue-400 rounded-bl-3xl rounded-tl-3xl rounded-tr-xl text-white"
                >

                    {{message.message}}
                   <a href="#" @click.prevent="downloadFile(message.file)">скачать</a>

                </div>
                <img
                    src="https://source.unsplash.com/vpOeXr5wmR4/600x600"
                    class="object-cover h-8 w-8 rounded-full"
                    alt=""
                />
            </div>

        </div>
        <div class="py-5">
            <input @keypress.enter="submit"
                   v-model="message"
                class="w-full bg-gray-300 py-5 px-3 rounded-xl"
                type="text"
                placeholder="type your message here..."
            />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import {ref} from "vue";
export default {
    name: "ChatComponent",
    data(){
        return{
            messagess:[],
            message: '',
            file:'',
        }
    },

    mounted() {
      this.get()
    },
    methods:{
        async  submit()
        {
      let res =  await   axios.post(`/chat/store/${this.$parent.recipient}`, {message: this.message, file: this.file})

        },

        async  get()
        {
       let res =  await  axios.get(`/chat/get/${this.$parent.recipient}`, {message: this.message})
       this.messagess = res.data
        },

        downloadFile($file)
        {
           axios.get(`donwload/${$file}`).then(res=>{
               console.log(res)
           })
        }
    },

    created() {
        Echo.private(`chat`)
            .listen('MessageEvent', (e) => {
             this.messagess.push({
                    message: e.message.message,
                    message_sender: e.message.sender_id,
                    message_recipient: e.message.recipient_id,
                    message_file: e.message.file
                });
                console.log(e)
            });

    }
}
</script>

<style scoped>

</style>
