<x-app-layout>
   


      <div class="max-w-6xl mx-auto">
        <!-- Tarjetas de Resumen -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-blue-500 text-white p-6 rounded-xl shadow-lg">
                <h3 class="text-3xl font-bold">150</h3>
                <p>New Orders</p>
            </div>
            <div class="bg-green-500 text-white p-6 rounded-xl shadow-lg">
                <h3 class="text-3xl font-bold">53%</h3>
                <p>Bounce Rate</p>
            </div>
            <div class="bg-yellow-500 text-white p-6 rounded-xl shadow-lg">
                <h3 class="text-3xl font-bold">44</h3>
                <p>User Registrations</p>
            </div>
            <div class="bg-red-500 text-white p-6 rounded-xl shadow-lg">
                <h3 class="text-3xl font-bold">65</h3>
                <p>Unique Visitors</p>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <!-- Gráfico de Ventas -->
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h3 class="text-lg font-semibold mb-4">Sales</h3>
                <canvas id="salesChart"></canvas>
            </div>

            <!-- Mapa de Visitantes (Imagen Estática) -->
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h3 class="text-lg font-semibold mb-4">Visitors</h3>
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/66/Usa_edcp_relief_location_map.png" alt="Mapa" class="rounded-xl w-full">
            </div>
        </div>
    </div>

    <script>
        // Código para generar el gráfico de ventas con Chart.js
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Sales',
                    data: [65, 59, 80, 81, 56, 55, 40],
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderWidth: 2
                }]
            }
        });
    </script>
</x-app-layout>
