  
  <script setup>
  import AppLayout from '@/layouts/AppLayout.vue';
  import { Head, useForm } from '@inertiajs/vue3';
  import { Input } from '@/components/ui/input';
  import { Button } from '@/components/ui/button';
  
  const props = defineProps({ roles: Array });
  
  const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    roles: [],
  });
  
  const submit = () => {
    form.post(route('users.store'));
  };
  
  const breadcrumbs = [
    { title: 'Users', href: route('users.index') },
    { title: 'Create', href: route('users.create') },
  ];
  </script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
      <Head title="Add User" />
      <div class="w-full max-w-[600px] mx-auto mt-5">
        
      <form @submit.prevent="submit" class="max-w-[600px] mx-auto mt-6 space-y-4">
        
        <Label for="name">Name</Label>
        <Input id="name" v-model="form.name" label="Name" required placeholder="name" />
        
        <Label for="email">Email</Label>
        <Input id="email" v-model="form.email" label="Email" type="email" required />
        
        <Label for="password">Password</Label>
        <Input id="password" v-model="form.password" label="Password" type="password" required />
        <Label for="password_confirmation">Confirm Password</Label>
        <Input id="password_confirmation" v-model="form.password_confirmation" label="Confirm Password" type="password" required />
  
        <div>
          <label>Assign Roles</label>
          <div class="grid grid-cols-2 gap-2 mt-2">
            <label v-for="role in roles" :key="role.id">
              <input type="checkbox" :value="role.id" v-model="form.roles" />
              {{ role.name }}
            </label>
          </div>
        </div>
  
        <Button type="submit">Create User</Button>
      </form>
      </div>
    </AppLayout>
  </template>
  