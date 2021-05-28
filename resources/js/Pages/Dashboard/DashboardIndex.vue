<template>
    <layout title="Home | VLB Discipleship Data">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    Home
                </h1>
            </div>
        </header>
        <main class="bg-gray-100">
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <select id="leaders-options"
                    v-model="leaderSelected"
                >
                    <option v-for="(option, index) in leadersOptions" 
                        :value="index"
                        :key="index"
                    >
                        {{ option.vgLeader }}
                    </option>
                </select>
                <button @click.prevent="searchLeaderData"
                    class="rounded-md py-2 px-4 bg-blue-500 text-white"
                >
                    Search
                </button>
            </div>
        </main>
        
    </layout>
</template>


<script>
    import Layout from '../Layout';

    export default {
        components: {
            Layout,
        },

        props: ['leadersOptions'],

        data() {
            return {
                'leaderSelected': 0
            }
        },

        methods: {
            searchLeaderData() {
                const indexSelected = this.leaderSelected;

                const leaderData = this.leadersOptions[indexSelected];
                let url = encodeURI(`${leaderData.gSheetId}/${leaderData.vgLeader}`);
                
                this.$inertia.get(`/vg-data/${url}`);
                
            }
        }
    }
</script>