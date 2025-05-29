<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';

const props = defineProps({
  user: Object,
  roles: Array,
  userRoles: Array
});

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  roles: [...props.userRoles],
});

const submit = () => {
  form.put(route('users.update', props.user.id));
};

const breadcrumbs = [
  { title: 'Users', href: route('users.index') },
  { title: 'Edit', href: '#' },
];
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Edit User" />
      <div class="w-full max-w-[600px] mx-auto mt-5">
        
        <form @submit.prevent="submit" class="max-w-xl mx-auto mt-6 space-y-4">
          
          
          <Label for="name">Name</Label>
          <Input id="name" v-model="form.name" label="Name" required />
          <Label for="email">Email</Label>
          <Input id="email" v-model="form.email" label="Email" type="email" required />

          <div>
            <label>Assign Roles</label>
            <div class="grid grid-cols-2 gap-2 mt-2">
              <label v-for="role in roles" :key="role.id">
                <input type="checkbox" :value="role.id" v-model="form.roles" />
                {{ role.name }}
              </label>
            </div>
          </div>

          <Button type="submit">Update User</Button>
        </form>
      </div>
  </AppLayout>
</template>

