<template>
    <div>
        <table>
            <thead>
                <tr>
                    <th v-for="(value, name) in vgData[1]"
                        :key="name"
                    >
                        {{ name }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(memberData, index) in vgData"
                    :key="index"
                >
                    <td v-for="(value, name) in memberData"
                        :key="name"
                    >
                        {{ value }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>


<script>
    export default {
        props: ['data'],

        data() {
            return {
                'vgData': []
            }
        },

        methods: {
            searchLeaderData() {
                const indexSelected = this.leaderSelected;

                const leaderData = this.leadersOptions[indexSelected];
                console.log(leaderData);
                
            }
        },

        mounted() {
            this.vgData = this.data;
        }
    }
</script>