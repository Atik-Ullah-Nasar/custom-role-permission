<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { ref, watch } from 'vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Role',
        href: route('roles.index'),
    },
];

const props = defineProps<{
    roles: {
        id: number;
        name: string;
    }[]
}>();

const searchTerm = ref('');

const subscriptionChange = (role, action) => {
    if (action === 'edit') {
        router.visit(route('roles.edit', role.id));
    } else if (action === 'delete') {
        if (confirm(`Are you sure you want to delete the role "${role.name}"?`)) {
            router.delete(route('roles.destroy', role.id), {
                onSuccess: () => {
                    // Optional toast
                    // toast.success('Role deleted successfully');
                    router.reload({ only: ['roles'] }); // Reload only the roles list
                },
            });
        }
    }
};
</script>

<template>
    <Head title="Roles" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="w-full max-w-[800px] mx-auto mt-5">
            <div class="card bg-white p-4 shadow rounded">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold">Role List</h2>
                    <Button @click="$inertia.visit(route('roles.create'))">+ Create New Role</Button>
                </div>

                <table class="table-auto w-full text-left border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">#</th>
                            <th class="p-2 border">Name</th>
                            <th class="p-2 border text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(role, index) in props.roles" :key="role.id" class="hover:bg-gray-50">
                            <td class="p-2 border">{{ index + 1 }}</td>
                            <td class="p-2 border">{{ role.name }}</td>
                            <td class="p-2 border text-center">
                                <div class="flex justify-center gap-2">
                                    <Button size="sm" @click="subscriptionChange(role, 'edit')">Edit</Button>
                                    <Button size="sm" variant="destructive" @click="subscriptionChange(role, 'delete')">
                                        Delete
                                    </Button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="props.roles.length === 0">
                            <td colspan="3" class="text-center p-4 text-gray-500">No roles found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
