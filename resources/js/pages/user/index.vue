<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

const props = defineProps({ users: Array });

const breadcrumbs = [
  { title: 'Users', href: route('users.index') },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
      <Head title="Users" />
      <div class="p-4 max-w-4xl mx-auto">
        <div class="flex justify-between mb-4">
          <h2 class="text-lg font-semibold">User List</h2>
          <Button @click="$inertia.visit(route('users.create'))">+ Add User</Button>
        </div>
  
        <table class="table-auto w-full border">
          <thead class="bg-gray-100">
            <tr>
              <th class="p-2 border">#</th>
              <th class="p-2 border">Name</th>
              <th class="p-2 border">Email</th>
              <th class="p-2 border">Roles</th>
              <th class="p-2 border">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(user, index) in users" :key="user.id">
              <td class="p-2 border">{{ index + 1 }}</td>
              <td class="p-2 border">{{ user.name }}</td>
              <td class="p-2 border">{{ user.email }}</td>
              <td class="p-2 border">{{ user.roles.map(r => r.name).join(', ') }}</td>
              <td class="p-2 border text-center">
                <Button @click="$inertia.visit(route('users.edit', user.id))">Edit</Button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </AppLayout>
  </template>
  
  