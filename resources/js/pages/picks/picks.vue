<script setup lang="ts">
import { computed } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

interface GameOption {
  gameId: number;
  over: string;
  under: string;
  favorite: string;
  underdog: string;
}

interface Selection {
  over: number | null;
  under: number | null;
  favorite: number | null;
  underdog: number | null;
  overString?: string;
  underString?: string;
  favoriteString?: string;
  underdogString?: string;
}

const props = defineProps<{
  options: {
    data: GameOption[];
  };
  selections: {
    data: Selection[];
  };
}>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Make yer picks',
    href: '/picks',
  },
];

const form = useForm({
  over: props.selections.data[0]?.over?.toString() ?? 'n/a',
  under: props.selections.data[0]?.under?.toString() ?? 'n/a',
  favorite: props.selections.data[0]?.favorite?.toString() ?? 'n/a',
  underdog: props.selections.data[0]?.underdog?.toString() ?? 'n/a',
});

const currentSelection = computed(() => props.selections.data[0]);

const hasCurrentPicks = computed(() => {
  const selection = currentSelection.value;
  return selection && (selection.over || selection.under || selection.favorite || selection.underdog);
});

const isGameSelected = (gameId: number, exclude: string) => {
    if (props.selections.data[0][exclude as keyof Selection] === gameId || form[exclude as keyof typeof form] === gameId.toString()) {
      return true;
    }
  return false;
};

const overOptions = computed(() => props.options.data.map(option => ({
  ...option,
  disabled: isGameSelected(option.gameId, 'under'),
})));

const underOptions = computed(() => props.options.data.map(option => ({
  ...option,
  disabled: isGameSelected(option.gameId, 'over'),
})));

const favoriteOptions = computed(() => props.options.data.map(option => ({
  ...option,
  disabled: isGameSelected(option.gameId, 'underdog'),
})));

const underdogOptions = computed(() => props.options.data.map(option => ({
  ...option,
  disabled: isGameSelected(option.gameId, 'favorite'),
})));

const submit = () => {
  form.post('/picks', {
    onSuccess: () => {
      form.over = '';
      form.under = '';
      form.favorite = '';
      form.underdog = '';
    },
  });
};
</script>

<template>
  <Head>
    <title>Picks Pool</title>
    <meta name="Picks-Pool" content="Picks-Pool">
  </Head>
  <AppLayout :breadcrumbs="breadcrumbs">
    <div v-if="hasCurrentPicks">
      <h2>Current picks:</h2>
      <p v-if="currentSelection.overString">{{ currentSelection.overString }}</p>
      <p v-if="currentSelection.underString">{{ currentSelection.underString }}</p>
      <p v-if="currentSelection.favoriteString">{{ currentSelection.favoriteString }}</p>
      <p v-if="currentSelection.underdogString">{{ currentSelection.underdogString }}</p>
    </div>

    <form @submit.prevent="submit">
      <div class="flex space-x-4">
        <Select v-model="form.over" name="over">
          <SelectTrigger class="w-[180px]">
            <SelectValue placeholder="Over" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="n/a">n/a</SelectItem>
            <SelectItem v-for="option in overOptions" :key="option.gameId" :value="option.gameId.toString()" :disabled="option.disabled">
              {{ option.over }}
            </SelectItem>
          </SelectContent>
        </Select>

        <Select v-model="form.under" name="under">
          <SelectTrigger class="w-[180px]">
            <SelectValue placeholder="Under" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="n/a">n/a</SelectItem>
            <SelectItem v-for="option in underOptions" :key="option.gameId" :value="option.gameId.toString()" :disabled="option.disabled">
              {{ option.under }}
            </SelectItem>
          </SelectContent>
        </Select>

        <Select v-model="form.favorite" name="favorite">
          <SelectTrigger class="w-[180px]">
            <SelectValue placeholder="Favorite" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="n/a">n/a</SelectItem>
            <SelectItem v-for="option in favoriteOptions" :key="option.gameId" :value="option.gameId.toString()" :disabled="option.disabled">
              {{ option.favorite }}
            </SelectItem>
          </SelectContent>
        </Select>

        <Select v-model="form.underdog" name="underdog">
          <SelectTrigger class="w-[180px]">
            <SelectValue placeholder="Underdog" />
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="n/a">n/a</SelectItem>
            <SelectItem v-for="option in underdogOptions" :key="option.gameId" :value="option.gameId.toString()" :disabled="option.disabled">
              {{ option.underdog }}
            </SelectItem>
          </SelectContent>
        </Select>
      </div>

      <Button type="submit" :disabled="form.processing" class="mt-4">Submit Picks</button>
    </form>
  </AppLayout>
</template>
