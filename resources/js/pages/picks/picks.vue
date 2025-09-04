<script setup lang="ts">
import { ref } from 'vue'
import { Form, useForm, Head } from '@inertiajs/vue3';
import {Select, SelectContent, SelectItem, SelectTrigger, SelectValue} from '@/components/ui/select/';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

function anyPicks(g1: any, g2: any, g3: any, g4: any){
  return g1 || g2 || g3 || g4;
}

function isSameGame(gameOne: any, gameTwo: any, gameThree:any): Boolean{
  return gameOne === gameTwo || gameOne == gameThree;
}


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Make yer picks',
        href: '/picks',
    },
];

const props = defineProps({
  options:
  {
    type:Object,
    required:true,
  },
  selections:
  {
    type:Object,
    required:true,
  }
 });

 const form = useForm({
  over: 'n/a',
  under: 'n/a',
  favorite: 'n/a',
  underdog: 'n/a'
});

const overSelected = ref([]);
const underSelected = ref([]);
const favoriteSelected = ref([]);
const underdogSelected = ref([]);

</script>

<template>
  <Head>
    <title>Picks Pool</title>
    <meta name="Picks-Pool" content="Picks-Pool">
  </Head>
  <AppLayout :breadcrumbs="breadcrumbs">
    <div>
    <h2 v-if="anyPicks(selections.data[0].over, selections.data[0].under, selections.data[0].favorite, selections.data[0].underdog, )"> Current picks:</h2>
    <p v-if="selections.data[0].over">{{ selections.data[0].overString }}</p>
    <p v-if="selections.data[0].under">{{ selections.data[0].underString }}</p>
    <p v-if="selections.data[0].favorite">{{ selections.data[0].favoriteString }}</p>
    <p v-if="selections.data[0].underdog">{{ selections.data[0].underdogString }}</p>
    </div>
    <Form action="/picks" method="post" :resetOnSucces="['over']">
      <Select v-model="overSelected" name="over">
        <SelectTrigger class="w-[180px]">
          <SelectValue placeholder="n/a" />
        </SelectTrigger>
        <SelectContent>
          <SelectItem value="n/a">
            n/a
          </SelectItem>
          <template v-for="option in options.data">
            <SelectItem v-if="isSameGame(option.gameId, underSelected, props.selections.data[0].under)" disabled :value="option.gameId">
              {{ option.over }}
            </SelectItem>
            <SelectItem v-else :value="option.gameId">
              {{ option.over }}
            </SelectItem>
          </template>
        </SelectContent>
      </Select>

      <Select v-model="underSelected" name="under">
        <SelectTrigger class="w-[180px]">
         <SelectValue placeholder="n/a" />
        </SelectTrigger>
        <SelectContent>
          <SelectItem value="n/a">
            n/a
          </SelectItem>
          <template v-for="option in options.data">
            <SelectItem v-if="isSameGame( option.gameId, overSelected, props.selections.data[0].over)" disabled :value="option.gameId">
              {{ option.under }}
            </SelectItem>
            <SelectItem v-else :value="option.gameId">
              {{ option.under}}
            </SelectItem>
          </template>
        </SelectContent>
      </Select>

      <Select v-model="favoriteSelected" name="favorite">
        <SelectTrigger class="w-[180px]">
         <SelectValue placeholder="n/a" />
        </SelectTrigger>
        <SelectContent>
          <SelectItem value="n/a">
            n/a
          </SelectItem>
          <template v-for="option in options.data">
            <SelectItem v-if="isSameGame( option.gameId, underdogSelected, props.selections.data[0].underdog)" disabled :value="option.gameId">
              {{ option.favorite }}
            </SelectItem>
            <SelectItem v-else :value="option.gameId">
              {{ option.favorite}}
            </SelectItem>
          </template>
        </SelectContent>
      </Select>

      <Select v-model="underdogSelected" name="underdog">
        <SelectTrigger class="w-[180px]">
         <SelectValue placeholder="n/a" />
        </SelectTrigger>
        <SelectContent>
          <SelectItem value="n/a">
            n/a
          </SelectItem>
          <template v-for="option in options.data">
            <SelectItem v-if="isSameGame( option.gameId, favoriteSelected, props.selections.data[0].favorite)" disabled :value="option.gameId">
              {{ option.underdog }}
            </SelectItem>
            <SelectItem v-else :value="option.gameId">
              {{ option.underdog}}
            </SelectItem>
          </template>
        </SelectContent>
      </Select>
      <Button type="submit" :disabled="form.processing">Submit Picks</button>
    </Form>
  </AppLayout>
</template>