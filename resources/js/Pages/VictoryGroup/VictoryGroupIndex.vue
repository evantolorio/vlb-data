<template>
    <layout title="Victory Group | VLB Discipleship Data">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    Victory Group
                </h1>
            </div>
        </header>
        <main class="bg-gray-100">
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <template v-if="editMode">
                    <button @click.prevent="editMode = !editMode"
                        class="rounded-md py-2 px-4 text-white bg-red-500"
                    >
                        Cancel
                    </button>
                    <button @click.prevent="updateData"
                        class="rounded-md py-2 px-4 text-white bg-red-500"
                    >
                        Save
                    </button>
                </template>
                <template v-else>
                    <button @click.prevent="editMode = !editMode"
                        class="rounded-md py-2 px-4 text-white bg-blue-500"
                    >
                        Edit
                    </button>
                </template>
                <!-- This example requires Tailwind CSS v2.0+ -->
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            School Information
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Discipleship Journey
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="(memberData, index) in vgData"
                                        :key="index"
                                    >
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                            <div>
                                                <div class="text-base font-medium text-gray-900">
                                                    {{ memberData['Name'] }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ memberData['Member/Intern'] }} ({{ memberData['New/Old'] }})
                                                </div>
                                            </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                :class="statusClass(memberData['Attendance'])"
                                            >
                                                {{ memberData['Attendance'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ memberData['College/School'] }}</div>
                                            <div class="text-sm text-gray-500">{{ memberData['Course/Strand'] }}</div>
                                            <div class="text-sm text-gray-500">{{ memberData['Batch/Grade'] }}</div>
                                        </td>
                                        <td class="grid grid-cols-2 px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="flex items-center text-sm text-gray-900">
                                                    <template v-if="memberData['One2One'].search('Done') != -1">
                                                        <victory-group-done-icon></victory-group-done-icon>
                                                    </template>
                                                    <template v-else-if="memberData['One2One'].search('Not yet') != -1">
                                                        <victory-group-not-yet-icon></victory-group-not-yet-icon>
                                                    </template>
                                                    <template v-else>
                                                        <victory-group-ongoing-icon></victory-group-ongoing-icon>
                                                    </template>
                                                    One2One
                                                </div>
                                                <div class="flex items-center text-sm text-gray-900">
                                                    <template v-if="memberData['Victory Weekend'].search('Done') != -1">
                                                        <victory-group-done-icon></victory-group-done-icon>
                                                    </template>
                                                    <template v-else-if="memberData['Victory Weekend'].search('Not yet') != -1">
                                                        <victory-group-not-yet-icon></victory-group-not-yet-icon>
                                                    </template>
                                                    <template v-else>
                                                        <victory-group-ongoing-icon></victory-group-ongoing-icon>
                                                    </template>
                                                    Victory Weekend
                                                </div>
                                                <div class="flex items-center text-sm text-gray-900">
                                                    <template v-if="memberData['Purple Book Class'].search('Done') != -1">
                                                        <victory-group-done-icon></victory-group-done-icon>
                                                    </template>
                                                    <template v-else-if="memberData['Purple Book Class'].search('Not yet') != -1">
                                                        <victory-group-not-yet-icon></victory-group-not-yet-icon>
                                                    </template>
                                                    <template v-else>
                                                        <victory-group-ongoing-icon></victory-group-ongoing-icon>
                                                    </template>
                                                    Purple Book Class
                                                </div>
                                                <div class="flex items-center text-sm text-gray-900">
                                                    <template v-if="memberData['Church Community'].search('Done') != -1">
                                                        <victory-group-done-icon></victory-group-done-icon>
                                                    </template>
                                                    <template v-else-if="memberData['Church Community'].search('Not yet') != -1">
                                                        <victory-group-not-yet-icon></victory-group-not-yet-icon>
                                                    </template>
                                                    <template v-else>
                                                        <victory-group-ongoing-icon></victory-group-ongoing-icon>
                                                    </template>
                                                    Church Community
                                                </div>
                                                <div class="flex items-center text-sm text-gray-900">
                                                    <template v-if="memberData['Making Disciples'].search('Done') != -1">
                                                        <victory-group-done-icon></victory-group-done-icon>
                                                    </template>
                                                    <template v-else-if="memberData['Making Disciples'].search('Not yet') != -1">
                                                        <victory-group-not-yet-icon></victory-group-not-yet-icon>
                                                    </template>
                                                    <template v-else>
                                                        <victory-group-ongoing-icon></victory-group-ongoing-icon>
                                                    </template>
                                                    Making Disciples
                                                </div>
                                            </div>
                                            <div class="pl-4 whitespace-nowrap">
                                                <div class="text-sm">
                                                    <span class="text-gray-900">Doing 121 with others?</span><br>
                                                    <span class="text-gray-500">{{ memberData['Doing 121 with others?'] }}</span>
                                                </div>
                                                <div class="mt-5 text-sm">
                                                    <span class="text-gray-900">Volunteer Ministry</span><br>
                                                    <span class="text-gray-500">{{ memberData['Volunteer Ministry'] }}</span>
                                                </div>                                            
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <a href="#" class="ml-4 text-gray-600 hover:text-gray-900">Delete</a>
                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <table>
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
                        <template v-if="!editMode">
                            <tr v-for="(memberData, index) in vgData"
                                :key="index"
                            >
                                <td v-for="(value, name) in memberData"
                                    :key="name"
                                >
                                    {{ value }}
                                </td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr v-for="(memberData, index) in vgData"
                                :key="index"
                            >
                                <td v-for="(value, name) in memberData"
                                    :key="name"
                                >
                                    <input type="text" 
                                        v-model="vgData[index][name]"
                                        class="form-input rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                                    >
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table> -->
            </div>
        </main>
    </layout>
</template>


<script>
    import Layout from '../Layout';
    import VictoryGroupDoneIcon from './VictoryGroupDoneIcon';
    import VictoryGroupOngoingIcon from './VictoryGroupOngoingIcon';
    import VictoryGroupNotYetIcon from './VictoryGroupNotYetIcon';

    export default {
        components: {
            Layout,
            VictoryGroupDoneIcon,
            VictoryGroupOngoingIcon,
            VictoryGroupNotYetIcon
        },

        props: ['data'],

        data() {
            return {
                'editMode': false,
                'vgData': []
            }
        },

        methods: {
            updateData() {
                this.$inertia.post(
                    window.location.href, 
                    { 'vgData': this.vgData },
                    { preserveState: false }
                );
            },

            statusClass(status) {
                let statusClass = '';

                if (status.search('Consistently') != -1 || status.search('Undergoing') != -1) 
                    statusClass = 'bg-green-100 text-green-800';
                else if (status.search('Not Regularly') != -1) 
                    statusClass = 'bg-yellow-100 text-yellow-800';
                else if (status.search('Stopped Attending') != -1 || status.search('Stopped Undergoing') != -1) 
                    statusClass = 'bg-red-100 text-red-800';
                else statusClass = 'bg-blue-100 text-blue-800';

                return statusClass;
            }
        },

        mounted() {
            this.vgData = this.data;
        }
    }
</script>