
@extends('layouts.admin')

@section('content')

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="container mx-auto px-4 py-8">
    <!-- Dashboard Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Total Users Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-blue-500">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-blue-500 uppercase mb-1">Utilisateurs Total</div>
                        <div class="text-xl font-bold text-gray-800">7</div>
                    </div>
                    <div>
                        <i class="fas fa-users text-2xl text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Trips Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-green-500">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-green-500 uppercase mb-1">Trajets Complétés</div>
                        <div class="text-xl font-bold text-gray-800">3</div>
                    </div>
                    <div>
                        <i class="fas fa-check-circle text-2xl text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-cyan-500">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-cyan-500 uppercase mb-1">Revenus Totaux</div>
                        <div class="text-xl font-bold text-gray-800">100 DH</div>
                    </div>
                    <div>
                        <i class="fas fa-dollar-sign text-2xl text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Drivers Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-yellow-500">
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-yellow-500 uppercase mb-1">Chauffeurs Actifs</div>
                        <div class="text-xl font-bold text-gray-800">12</div>
                    </div>
                    <div>
                        <i class="fas fa-taxi text-2xl text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
        <!-- Recent Trips -->
        <div class="lg:col-span-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4">
                <div class="px-4 py-3 flex items-center justify-between border-b">
                    <h6 class="text-lg font-bold text-blue-500">Trajets Récents</h6>
                </div>
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">ID</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">Chauffeur</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">Passager</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">Statut</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">Date</th>
                                    <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-200"></td>
                                    <td class="py-2 px-4 border-b border-gray-200"></td>
                                    <td class="py-2 px-4 border-b border-gray-200"></td>
                                    <td class="py-2 px-4 border-b border-gray-200"></td>
                                    <td class="py-2 px-4 border-b border-gray-200"></td>
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        <a href="" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded text-sm">Détails</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Driver Availability -->
        <div class="lg:col-span-4">
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4">
                <div class="px-4 py-3 border-b">
                    <h6 class="text-lg font-bold text-blue-500">Disponibilité des Chauffeurs</h6>
                </div>
                <div class="p-4">
                    <div class="pt-4 h-64">
                        <canvas id="driverAvailabilityChart"></canvas>
                    </div>
                    <div class="mt-4 text-center text-sm flex justify-center space-x-4">
                        <span class="flex items-center">
                            <i class="fas fa-circle text-green-500 mr-1"></i> Disponible
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-circle text-yellow-500 mr-1"></i> En course
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-circle text-red-500 mr-1"></i> Indisponible
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById("driverAvailabilityChart");
        // Default values for demonstration
        var availableDrivers = 5;
        var busyDrivers = 3;
        var unavailableDrivers = 2;
        
        // Check if template variables are passed
        try {
            // availableDrivers = {{ $availableDrivers ?? 0 }};
            // busyDrivers = {{ $busyDrivers ?? 0 }};
            // unavailableDrivers = {{ $unavailableDrivers ?? 0 }};
        } catch (e) {
            console.log("Using default values for chart");
        }
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Disponible", "En course", "Indisponible"],
                datasets: [{
                    data: [availableDrivers, busyDrivers, unavailableDrivers],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                    hoverBackgroundColor: ['#059669', '#d97706', '#dc2626'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)"
                }]
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10
                },
                legend: {
                    display: false
                },
                cutoutPercentage: 80
            }
        });
    });
</script>

@endsection