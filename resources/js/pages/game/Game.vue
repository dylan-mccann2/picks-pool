<script setup lang="ts">
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { type BreadcrumbItem } from '@/types';
import AppLayout from '@/layouts/AppLayout.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'The Slate',
        href: '/games',
    },
];

defineProps({
  games:
  {
    type:Object,
    required:true,
  }
 });

</script>


<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
      <div class="grid auto-rows-min gap-4 md:grid-cols-4 ">
        <Card v-for="game in games.data" class="w-[auto]">
          <CardContent>
            <table>
              <tbody>
              <tr>
                <td>{{ game.away }}</td>
                <td>{{ game.over }}</td>
              </tr>
              <tr>
                <td>{{ game.home }}</td>
                <td>{{ game.spread }}</td>
              </tr>
              </tbody>
            </table>
          </CardContent>
          <CardFooter>
            {{ game.startTime }}
          </CardFooter>
        </Card>
      </div>
    </div>
  </AppLayout>
</template>


