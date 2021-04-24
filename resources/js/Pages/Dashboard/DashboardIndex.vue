<template>
    <layout title="Home | VLB Discipleship Data">
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