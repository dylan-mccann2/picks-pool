<script setup lang="ts">
import { ref } from 'vue'
import { Form } from '@inertiajs/vue3';
import {Select, SelectContent, SelectItem, SelectTrigger, SelectValue} from '@/components/ui/select/';
import { Button } from '@/components/ui/button';

const overSelected = ref([]);
const underSelected = ref([]);

function isSameGame(gameOne: any, gameTwo: any): Boolean{
  return gameOne === gameTwo;
}


defineProps({
  picks:
  {
    type:Object,
    required:true,
  }
 });

</script>

<template>

  <Form action="/picks" method="post" resetOnSucess disableWhileProcessing>
    <Select v-model="overSelected" name="over">
      <SelectTrigger class="w-[180px]">
        <SelectValue placeholder="n/a" />
      </SelectTrigger>
      <SelectContent>
        <SelectItem value="n/a">
          n/a
        </SelectItem>
        <template v-for="pick in picks.data">
          <SelectItem v-if="isSameGame(underSelected, pick.gameId)" disabled :value="pick.gameId">
            {{ pick.over }}
          </SelectItem>
          <SelectItem v-else :value="pick.gameId">
            {{ pick.over }}
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
        <template v-for="pick in picks.data">
          <SelectItem v-if="isSameGame(overSelected, pick.gameId)" disabled :value="pick.gameId">
            {{ pick.under }}
          </SelectItem>
          <SelectItem v-else :value="pick.gameId">
            {{ pick.under}}
          </SelectItem>
        </template>
      </SelectContent>
    </Select>
    <Button type="submit">Submit Picks</button>
  </Form>
</template>