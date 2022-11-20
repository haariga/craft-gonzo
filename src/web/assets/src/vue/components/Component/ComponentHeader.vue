<template>
  <header
    class="flex gap-6 items-center text-white font-semibold uppercase text-sm"
  >
    <div class="relative">
      <Combobox
        :model-value="modelValue"
        @update:modelValue="(value) => emit('update:modelValue', value)"
      >
        <div class="bg-fuchsia-800 text-white">
          <div
            class="relative flex w-full cursor-default overflow-hidden rounded-lg text-left shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 focus-visible:ring-offset-2 focus-visible:ring-offset-teal-300 sm:text-sm"
          >
            <ComboboxInput
              class="bg-transparent border-0 text-white font-bold px-4 py-2"
              @change="query = $event.target.value"
            />
            <ComboboxButton
              class="flex items-center bg-transparent border-0 border-l"
            >
              <ArrowDownIcon class="w-4 h-4 text-white" />
            </ComboboxButton>
          </div>
          <ComboboxOptions
            class="absolute list-none p-0 m-0 mt-1 max-h-60 w-full overflow-auto rounded-md bg-fuchsia-700 py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
          >
            <ComboboxOption
              v-for="variant in filteredVariants"
              :key="variant"
              :value="variant"
              v-slot="{ active, selected }"
            >
              <li
                class="py-2 px-4 flex items-center"
                :class="{
                  'bg-fuchsia-800': selected,
                  'bg-fuchsia-400': active,
                }"
              >
                {{ variant }}
                <CheckBadgeIcon v-if="selected" class="w-4 h-4 ml-4" />
              </li>
            </ComboboxOption>
          </ComboboxOptions>
        </div>
      </Combobox>
    </div>
    <div class="flex gap-2 items-center">
      <span
        class="w-2 h-2 inline-block rounded-full"
        :style="{ backgroundColor: status.color }"
      ></span>
      <span>{{ status.label }}</span>
    </div>
  </header>
</template>

<script setup lang="ts">
import type { IComponent } from '@/vue/components/Sidebar/SidebarComponent.vue';
import { ArrowDownIcon, CheckBadgeIcon } from '@heroicons/vue/24/solid';
import {
  Combobox,
  ComboboxButton,
  ComboboxInput,
  ComboboxOption,
  ComboboxOptions,
} from '@headlessui/vue';
import { computed, ref } from 'vue';

interface IComponentHeader {
  variants: IComponent;
  status: {
    color: string;
    label: string;
  };
  modelValue: string;
}
const props = defineProps<IComponentHeader>();

const query = ref('');

const filteredVariants = computed(() => {
  return props.variants
    .filter((variant: IComponent) => {
      return variant.name.toLowerCase().includes(query.value.toLowerCase());
    })
    .map((variant: IComponent) => variant.name);
});

const emit = defineEmits(['update:modelValue']);
</script>
