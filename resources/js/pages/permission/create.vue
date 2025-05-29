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

const form = useForm({
  name: '',
});

const submit = () => {
  form.post(route('permissions.store'), {
    onSuccess: () => {
alert('successfully added');
form.reset();
    },
    onFinish: () => {
      location.href = route('permissions.index');
    },
  });
};

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Permissions',
    href: route('permissions.index'),
  },
  {
    title: 'Create',
    href: route('permissions.create'),
  },
];
</script>

<template>
  <Head title="Permission" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="w-full max-w-[600px] mx-auto mt-5">
      <div class="mb-4">
        <Link
          class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
          :href="route('permissions.index')"
        >Back to list</Link>
      </div>

      <form @submit.prevent="submit" class="min-w-[400px]">
        <div>
          <Label for="name">Permission Name</Label>
          <Input id="name" class="mt-3" type="text" required autofocus v-model="form.name" placeholder="Enter permission name" />
          <InputError :message="form.errors.name" />
        </div>

        <div>
          <Button type="submit" class="mt-4 w-full" :disabled="form.processing">
            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
            Add Permission
          </Button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
