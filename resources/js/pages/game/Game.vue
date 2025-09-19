<script setup lang="ts">
import {
  Card,
  CardContent,
  CardFooter,
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
          <CardContent class="p-4 pb-0">
            <div class="grid grid-cols-2 gap-x-4 gap-y-2">
              <div class="text-left">{{ game.away }}</div>
              <div class="text-right font-semibold">{{ game.over }}</div>
              <div class="text-left">{{ game.home }}</div>
              <div class="text-right font-semibold">{{ game.spread }}</div>
            </div>
          </CardContent>
          <CardFooter class="p-4 pt-0 pb-0">
            <div class="text-sm text-muted-foreground text-right">
            {{ game.startTime }}
            </div>
          </CardFooter>
        </Card>
      </div>
    </div>
  </AppLayout>
</template>


