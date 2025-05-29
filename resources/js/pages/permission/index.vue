<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { ref, watch } from 'vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: '/dashboard',
  },
  {
    title: 'Permission',
    href: route('permissions.index'),
  },
];

const props = defineProps<{
  permissions: {
    id: number;
    name: string;
  }[];
}>();

const searchTerm = ref('');

const subscriptionChange = (permission, action) => {
  if (action === 'edit') {
    router.visit(route('permissions.edit', permission.id));
  } else if (action === 'delete') {
    if (confirm(`Are you sure you want to delete the permission "${permission.name}"?`)) {
      router.delete(route('permissions.destroy', permission.id), {
        onSuccess: () => {
          // toast.success('Permission deleted successfully');
          router.reload({ only: ['permissions'] });
        },
      });
    }
  }
};
</script>

<template>
  <Head title="Permissions" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="w-full max-w-[800px] mx-auto mt-5">
      <div class="card bg-white p-4 shadow rounded">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-lg font-semibold">Permission List</h2>
          <Button @click="$inertia.visit(route('permissions.create'))">+ Create New Permission</Button>
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
            <tr v-for="(permission, index) in props.permissions" :key="permission.id" class="hover:bg-gray-50">
              <td class="p-2 border">{{ index + 1 }}</td>
              <td class="p-2 border">{{ permission.name }}</td>
              <td class="p-2 border text-center">
                <div class="flex justify-center gap-2">
                  <Button size="sm" @click="subscriptionChange(permission, 'edit')">Edit</Button>
                  <Button size="sm" variant="destructive" @click="subscriptionChange(permission, 'delete')">
                    Delete
                  </Button>
                </div>
              </td>
            </tr>
            <tr v-if="props.permissions.length === 0">
              <td colspan="3" class="text-center p-4 text-gray-500">No permissions found.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>
