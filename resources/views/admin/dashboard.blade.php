@extends('layouts.master')

@section('title', 'Dashboard Admin')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="mini-stats-wid card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Total Magang</p>
                            <h4 class="mb-0">{{ $totalMagang }}</h4>
                        </div>
                        <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="bx bx-list-ol font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mini-stats-wid card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Total Pelatihan</p>
                            <h4 class="mb-0">{{ $totalPelatihan }}</h4>
                        </div>
                        <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="bx bx-list-check font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mini-stats-wid card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Total IHT</p>
                            <h4 class="mb-0">{{ $totalIht }}</h4>
                        </div>
                        <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="bx bx-user-voice font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Jumlah Magang / Bulan</h5>
                    <a href="{{ route('admin.laporan.magang') }}" class="btn btn-primary">
                        <i class="mdi mdi-file-document-box"></i> Laporan Magang
                    </a>
                </div>
                <div class="card-body">
                    <div id="chartMagang"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Pelatihan Luar RS / Bulan</h5>
                    <a href="{{ route('admin.laporan.pelatihan') }}" class="btn btn-primary">
                        <i class="mdi mdi-file-document-box"></i> Laporan Pelatihan Luar RS
                    </a>
                </div>
                <div class="card-body">
                    <div id="chartPelatihan"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Kegiatan IHT / Bulan</h5>
                    <a href="{{ route('admin.laporan.iht') }}" class="btn btn-primary">
                        <i class="mdi mdi-file-document-box"></i> Laporan IHT
                    </a>
                </div>
                <div class="card-body">
                    <div id="chartIht"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const labels = @json($bulan);
        const dataMagang = @json($dataMagang);
        const dataPelatihan = @json($dataPelatihan);
        const dataIht = @json($dataIht);

        const chartCommonOptions = (seriesName, data, color) => ({
            chart: {
                type: 'line',
                height: 350,
                zoom: { enabled: false }
            },
            series: [{
                name: seriesName,
                data: data
            }],
            xaxis: {
                categories: labels
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            colors: [color],
            markers: {
                size: 6,
                colors: [color],
                strokeColors: '#fff',
                strokeWidth: 2,
                hover: {
                    size: 8
                }
            },
            tooltip: {
                enabled: true
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            }
        });

        new ApexCharts(document.querySelector("#chartMagang"), chartCommonOptions("Magang", dataMagang, "#556ee6")).render();
        new ApexCharts(document.querySelector("#chartPelatihan"), chartCommonOptions("Pelatihan", dataPelatihan, "#34c38f")).render();
        new ApexCharts(document.querySelector("#chartIht"), chartCommonOptions("IHT", dataIht, "#f46a6a")).render();
    });
</script>

@endsection
