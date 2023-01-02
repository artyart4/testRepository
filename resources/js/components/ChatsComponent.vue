<template>
    <!-- component -->
    <!-- This is an example component -->
    <div class="container mx-auto shadow-lg rounded-lg">
        <!-- headaer -->
        <div class="px-5 py-5 flex justify-between items-center bg-white border-b-2">
            <div class="font-semibold text-2xl">GoingChat</div>
            <div class="w-1/2">
                <input
                    type="text"
                    name=""
                    id=""
                    placeholder="search IRL"
                    class="rounded-2xl bg-gray-100 py-3 px-5 w-full"
                />
            </div>
            <div
                class="h-12 w-12 p-2 bg-yellow-500 rounded-full text-white font-semibold flex items-center justify-center"
            >
                RA
            </div>
        </div>
        <!-- end header -->
        <!-- Chatting -->
        <div class="flex flex-row justify-between bg-white">
            <!-- chat list -->
            <div class="flex flex-col w-2/5 border-r-2 overflow-y-auto">
                <!-- search compt -->
                <div class="border-b-2 py-4 px-2">
                    <input
                        type="text"
                        placeholder="search chatting"
                        class="py-2 px-2 border-2 border-gray-200 rounded-2xl w-full"
                    />
                </div>
                <!-- end search compt -->
                <!-- user list -->
                <div v-for="chat in my_chats">
                    <div class="flex justify-center">
                        <ul class="bg-white rounded-lg w-96 text-gray-900">
                            <li class="px-6 py-2 border-b border-gray-200 w-full rounded-t-lg">
<!--                                <a :href="chat.recipient[0].id">{{chat.recipient[0].name}}:</a>-->
<!--                            <i>{{chat.last_message.message}}</i>-->
                            </li>
                            <li class="px-6 py-2 border-b border-gray-200 w-full"></li>
                            <li class="px-6 py-2 border-b border-gray-200 w-full">A third item</li>
                            <li class="px-6 py-2 border-b border-gray-200 w-full">A fourth item</li>
                            <li class="px-6 py-2 w-full rounded-b-lg">And a fifth one</li>
                        </ul>
                    </div>
                </div>

                <div v-for="chat in chat_with"
                    class="flex flex-row py-4 px-2 justify-center items-center border-b-2"
                >
                    <div class="w-1/4">
                        <img
                            src="https://source.unsplash.com/_7LbC5J-jw4/600x600"
                            class="object-cover h-12 w-12 rounded-full"
                            alt=""
                        />
                    </div>
                    <div class="w-full">
                        <div class="text-lg font-semibold" v-if="my_id === chat.sender_id"><a href=""  @click.prevent="get_messages(chat.recipient_id)">{{chat.recipient_name}}</a></div>
                        <div class="text-lg font-semibold" v-if="my_id === chat.recipient_id"><a href="" @click.prevent="get_messages(chat.sender_id)">{{chat.sender_name}}</a></div>
                        <span class="text-gray-500">{{chat.message}}</span>
                    </div>
                </div>
                <!-- end user list -->
            </div>
            <!-- end chat list -->
            <!-- message -->
<chat-component :messages="chat_with"></chat-component>
            <!-- end message -->
            <div class="w-2/5 border-l-2 px-5">
                <div class="flex flex-col">
                    <div class="font-semibold text-xl py-4">Mern Stack Group</div>
                    <img
                        src="https://source.unsplash.com/L2cxSuKWbpo/600x600"
                        class="object-cover rounded-xl h-64"
                        alt=""
                    />
                    <div class="font-semibold py-4">Created 22 Sep 2021</div>
                    <div class="font-light">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Deserunt,
                        perspiciatis!
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "ChatsComponent",
    data(){
        return {
            current_message_with: 2,
        }
    },
    props:['my_id', 'chat_with','recipient','my_chats'],
    methods:{

    },
    mounted() {

    }
}
</script>

<style scoped>

</style>
