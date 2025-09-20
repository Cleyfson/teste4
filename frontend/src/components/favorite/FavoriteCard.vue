<template>
  <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-4 flex items-center justify-between">
      <slot name="header"></slot>
    </div>
    <div class="min-h-[720px]">
      <slot></slot>
    </div>
  </div>
</template>