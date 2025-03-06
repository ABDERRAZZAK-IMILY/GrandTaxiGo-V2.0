@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-white">تقرير الإيرادات</h1>
            <a href="{{ route('admin.dashboard') }}" class="bg-white text-blue-600 px-4 py-2 rounded-md hover:bg-blue-50 transition">
                العودة للوحة التحكم
            </a>
        </div>
        
        <div class="p-6">
            <div class="flex justify-end items-center mb-6">
                <div class="flex space-x-2 rtl:space-x-reverse">
                    <a href="{{ route('admin.revenue', ['period' => 'week']) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 {{ $periodType == 'week' ? 'bg-blue-700' : '' }}">أسبوعي</a>
                    <a href="{{ route('admin.revenue', ['period' => 'month']) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 {{ $periodType == 'month' ? 'bg-blue-700' : '' }}">شهري</a>
                    <a href="{{ route('admin.revenue', ['period' => 'year']) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 {{ $periodType == 'year' ? 'bg-blue-700' : '' }}">سنوي</a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-blue-50 rounded-lg p-6 shadow">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">ملخص الإيرادات</h2>
                    <div class="flex flex-col space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">الفترة:</span>
                            <span class="font-medium">{{ $revenueData['start_date'] }} إلى {{ $revenueData['end_date'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">إجمالي الإيرادات:</span>
                            <span class="text-2xl font-bold text-green-600">{{ $revenueData['total'] }} درهم</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">عدد الحجوزات المؤكدة:</span>
                            <span class="font-medium">{{ count($revenueData['by_period']) }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 rounded-lg p-6 shadow">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">إحصائيات سريعة</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-lg shadow">
                            <div class="text-sm text-gray-500">متوسط الإيرادات اليومية</div>
                            <div class="text-xl font-bold text-blue-600">
                                @if(count($revenueData['by_period']) > 0)
                                    {{ round($revenueData['total'] / count($revenueData['by_period']), 2) }} درهم
                                @else
                                    0 درهم
                                @endif
                            </div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow">
                            <div class="text-sm text-gray-500">أعلى إيراد</div>
                            <div class="text-xl font-bold text-blue-600">
                                @if(count($revenueData['by_period']) > 0)
                                    {{ max(array_column($revenueData['by_period']->toArray(), 'count')) * 50 }} درهم
                                @else
                                    0 درهم
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">رسم بياني للإيرادات</h2>
                <div class="w-full h-80 bg-gray-50 rounded-lg p-4">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="flex justify-between items-center p-6 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">تفاصيل الإيرادات</h2>
                    <button id="exportCSV" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        تصدير CSV
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="revenueTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">التاريخ</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">عدد الحجوزات</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإيرادات</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($revenueData['by_period'] as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if(isset($item->date))
                                            {{ $item->date }}
                                        @else
                                            {{ $item['date'] }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if(isset($item->count))
                                            {{ $item->count }}
                                        @else
                                            {{ $item['count'] }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                                        @if(isset($item->count))
                                            {{ $item->count * 50 }} درهم
                                        @else
                                            {{ $item['count'] * 50 }} درهم
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">لا توجد بيانات متاحة</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        // تحويل البيانات إلى تنسيق Chart.js
        const revenueData = @json($revenueData['by_period']);
        const labels = [];
        const data = [];
        
        revenueData.forEach(item => {
            if (item.date) {
                labels.push(item.date);
                data.push(item.count * 50);
            } else {
                labels.push(item['date']);
                data.push(item['count'] * 50);
            }
        });
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'الإيرادات (درهم)',
                    data: data,
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'الإيرادات (درهم)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'التاريخ'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + ' درهم';
                            }
                        }
                    }
                }
            }
        });

        // تصدير البيانات إلى CSV
        document.getElementById('exportCSV').addEventListener('click', function() {
            const table = document.getElementById('revenueTable');
            const rows = table.querySelectorAll('tr');
            let csv = [];
            
            for (let i = 0; i < rows.length; i++) {
                const row = [], cols = rows[i].querySelectorAll('td, th');
                
                for (let j = 0; j < cols.length; j++) {
                    let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ');
                    data = data.replace(/"/g, '""');
                    row.push('"' + data + '"');
                }
                csv.push(row.join(','));
            }
            
            const csvString = csv.join('\n');
            const filename = 'revenue_report_' + new Date().toISOString().slice(0, 10) + '.csv';
            const link = document.createElement('a');
            link.style.display = 'none';
            link.setAttribute('target', '_blank');
            link.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(csvString));
            link.setAttribute('download', filename);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    });
</script>
@endpush
@endsection 