<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { LoaderCircle } from 'lucide-vue-next';

interface Permission {
    id: number
    name: string
}

const props = defineProps<{
    permissions: Permission[]
}>()

const form = useForm({
    name: '',
    permissions: []
});

const submit = () => {
    form.post(route('roles.store'), {
        onSuccess: () => {
            // Optional: toast.success('Role created successfully');
        },
        onFinish: () => {
            location.href = route('roles.index')
        },
    });
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Role',
        href: route('roles.index'),
    },
    {
        title: 'Create',
        href: route('roles.create'),
    },
];
</script>

<template>
    <Head title="Create Role" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="w-full max-w-[600px] mx-auto mt-5">
            <div class="mb-4">
                <Link
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                    :href="route('roles.index')">Back to list</Link>
            </div>

            <form @submit.prevent="submit" class="min-w-[400px]">
                <div>
                    <Label for="name">Add Role</Label>
                    <Input id="name" class="mt-3" type="text" required autofocus :tabindex="1" v-model="form.name"
                        placeholder="Role name" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-5">
                    <label v-for="permission in permissions" :key="permission.id"
                        class="flex items-center space-x-2 bg-gray-50 p-3 rounded hover:bg-gray-100">
                        <input type="checkbox" :value="permission.id" v-model="form.permissions"
                            class="form-checkbox text-indigo-600 focus:ring-indigo-500 rounded" />
                        <span class="text-sm text-gray-700">{{ permission.name }}</span>
                    </label>
                </div>

                <div>
                    <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Add
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
