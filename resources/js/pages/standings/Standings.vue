<script setup lang="ts">
import {
  Table,
  TableHeader,
  TableCaption,
  TableRow,
  TableHead,
  TableBody,
  TableCell,
} from '@/components/ui/table';
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'The Standings',
        href: '/standings',
    },
];

defineProps({
  standings:
  {
    type:Object,
    required:true,
  }
 });

</script>


<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
  <Table>
    <TableCaption>Current Standings.</TableCaption>
    <TableHeader>
      <TableRow>
        <TableHead class="w-[100px]">
          User
        </TableHead>
        <TableHead>Wins</TableHead>
        <TableHead>Losses</TableHead>
        <TableHead>Pushes</TableHead>
        <TableHead class="text-right">
          Gb
        </TableHead>
      </TableRow>
    </TableHeader>
    <TableBody>
      <TableRow v-for="user in standings.data" :key="user.id">
        <TableCell class="font-medium">
          {{ user.id }}
        </TableCell>
        <TableCell>{{ user.wins }}</TableCell>
        <TableCell>{{ user.losses }}</TableCell>
        <TableCell>{{ user.pushes }}</TableCell>
        <TableCell class="text-right">
          {{ user.gb }}
        </TableCell>
      </TableRow>
    </TableBody>
  </Table>
    </div>
  </AppLayout>
</template>


