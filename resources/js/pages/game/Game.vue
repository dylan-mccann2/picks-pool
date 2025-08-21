<script setup lang="ts">

defineProps({
  games:
  {
    type:Object,
    required:true,
  }
 });

</script>


<template>
  <div>
    <v-card v-for="game in games.data">
      <v-card-item>
        <v-card-title>{{ game.startTime }}</v-card-title>
      </v-card-item>
      <v-card-text>
        <table>
          <tr>
            <td>{{ game.away }}</td>
            <td>{{ game.over }}</td>
          </tr>
          <tr>
            <td>{{ game.home }}</td>
            <td>{{ game.spread }}</td>
          </tr>
        </table>
      </v-card-text>
    </v-card>
  </div>
</template>


