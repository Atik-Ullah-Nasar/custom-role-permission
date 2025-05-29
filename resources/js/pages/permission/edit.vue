<script setup lang="ts">
import { computed, ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm ,usePage } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const pageData = usePage().props;

const permission = pageData.permission;

const form = useForm({

    id: permission.id,
    name: permission.name,
});

const submit = () => {
  form.put(route('permissions.update', form.id), {
    onSuccess: () => {
      location.href = route('permissions.index');
    },
  });
};
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Permission',
        href: '/permission/list',
    },
];

</script>

<template>

    <Head title="Permission" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="w-full max-w-[600px] mx-auto mt-5">
            <div class="mb-4">
                <Link
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                    :href="route('permission.list')">Back to list</Link>
            </div>
            <form @submit.prevent="submit" class="min-w-[400px]">
                <Input id="name" type="hidden" v-model="form.id" />
                <div>
                    <Label for="name">Update Permission</Label>
                    <Input id="name" class="mt-3" type="text" required autofocus :tabindex="1" v-model="form.name"
                        placeholder="Update Permission" />
                    <InputError :message="form.errors.name" />
                </div>
                <div>
                    <Button type="submit" class="mt-4 w-full" :tabindex="4" :disabled="form.processing">
                        <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Update
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
