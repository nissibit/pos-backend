<template>
  <div>
    <input class="w3-input w3-border w3-border-theme w3-round-large" v-model="search"
      placeholder="Digita, pelo menos 3 letras, para procurar o produto" />

    <table class="w3-table-all w3-table-responsive w3-small w3-section">
      <thead>
        <tr class="w3-theme">
          <th>Codigo.</th>
          <th>Nome</th>
          <th>Preço</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="product in products" :key="product.id" class="w3-hover-theme">
          <td>{{ product.barcode }}</td>
          <td>{{ product.name }}</td>
          <td>{{ money(product.price) }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";
import axios from "axios";
import debounce from "lodash/debounce";
import { useFormatter } from '@/composables/useFormatter';
const { money } = useFormatter();
const products = ref([]);
const search = ref("");

const fetchProducts = async () => {
  const response = await axios.get("/api/products/fetch", {
    params: { q: search.value || "" }
  });
  products.value = response.data.data;
};

// debounce de 400ms
const debouncedFetch = debounce(fetchProducts, 400);
watch(search, (value) => {
  if (value.length >= 3 || value.length === 0) {
    debouncedFetch();
  }
});

onMounted(fetchProducts);
</script>