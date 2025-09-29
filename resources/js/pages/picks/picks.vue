<script setup lang="ts">
import { computed } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
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
    <div class="grid gap-6 p-4">
      <Card v-if="hasCurrentPicks">
        <CardHeader>
          <CardTitle>Current Picks</CardTitle>
        </CardHeader>
        <CardContent class="space-y-2">
          <p v-if="currentSelection.over" class="text-muted-foreground">{{ currentSelection.overString }}</p>
          <p v-if="currentSelection.under" class="text-muted-foreground">{{ currentSelection.underString }}</p>
          <p v-if="currentSelection.favorite" class="text-muted-foreground">{{ currentSelection.favoriteString }}</p>
          <p v-if="currentSelection.underdog" class="text-muted-foreground">{{ currentSelection.underdogString }}</p>
        </CardContent>
      </Card>

      <form @submit.prevent="submit">
        <Card>
          <CardHeader>
            <CardTitle>Make Yer Picks</CardTitle>
          <CardDescription>Select one option for each category. Leave a category empty or select n/a to keep current pick.</CardDescription>
          </CardHeader>
          <CardContent>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="grid gap-2">
                <Label for="over">Over</Label>
                <Select v-model="form.over" name="over" id="over">
                  <SelectTrigger>
                    <SelectValue placeholder="Select an Over" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="n/a">n/a</SelectItem>
                    <SelectItem v-for="option in overOptions" :key="option.gameId" :value="option.gameId.toString()" :disabled="option.disabled">
                      {{ option.over }}
                    </SelectItem>
                  </SelectContent>
                </Select>
              </div>

              <div class="grid gap-2">
                <Label for="under">Under</Label>
                <Select v-model="form.under" name="under" id="under">
                  <SelectTrigger>
                    <SelectValue placeholder="Select an Under" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="n/a">n/a</SelectItem>
                    <SelectItem v-for="option in underOptions" :key="option.gameId" :value="option.gameId.toString()" :disabled="option.disabled">
                      {{ option.under }}
                    </SelectItem>
                  </SelectContent>
                </Select>
              </div>

              <div class="grid gap-2">
                <Label for="favorite">Favorite</Label>
                <Select v-model="form.favorite" name="favorite" id="favorite">
                  <SelectTrigger>
                    <SelectValue placeholder="Select a Favorite" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="n/a">n/a</SelectItem>
                    <SelectItem v-for="option in favoriteOptions" :key="option.gameId" :value="option.gameId.toString()" :disabled="option.disabled">
                      {{ option.favorite }}
                    </SelectItem>
                  </SelectContent>
                </Select>
              </div>

              <div class="grid gap-2">
                <Label for="underdog">Underdog</Label>
                <Select v-model="form.underdog" name="underdog" id="underdog">
                  <SelectTrigger>
                    <SelectValue placeholder="Select an Underdog" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="n/a">n/a</SelectItem>
                    <SelectItem v-for="option in underdogOptions" :key="option.gameId" :value="option.gameId.toString()" :disabled="option.disabled">
                      {{ option.underdog }}
                    </SelectItem>
                  </SelectContent>
                </Select>
              </div>
            </div>
          </CardContent>
          <CardFooter>
            <Button type="submit" :disabled="form.processing">Submit Picks</Button>
          </CardFooter>
        </Card>
      </form>
    </div>
  </AppLayout>
</template>