@vite('resources/css/dashboard/index.css')
@extends('layouts.app')
@apexchartsScripts
@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <div id="upper_db">
            <h1>Dashboard</h1>
            <h2>Herzlich Willkommen {{ Auth::user()->name }} im
                <span style="color: lightskyblue;">{{ config('app.name') }}</span>
            </h2>
        </div>

        <!-- Statistikkacheln -->
        <div class="stats">
            <div class="stat-box">
                <h3>Gesamtmitglieder</h3>
                <p>{{ $mitgliedergesammt }}</p>
            </div>
            <div class="stat-box">
                <h3>Gesamte Einnahmen</h3>
                <p>{{ number_format($einnahmen, 2) }} €</p>
            </div>
            <div class="stat-box">
                <h3>Gesamte Ausgaben</h3>
                <p>{{ number_format($ausgaben, 2) }} €</p>
            </div>
        </div>

        <section id="charts">
            <!-- Diagramm zur Mitgliederanzahl pro Rang -->
            <div class="chart-container" id="mitgliederChartContainer" style="display: none;">
                <h2>Mitglieder({{ $mitgliedergesammt }}) nach Rang</h2>
                <div>
                    {!! $mitgliederChart->container() !!}
                    {!! $mitgliederChart->script() !!}
                </div>
            </div>

            <!-- Diagramm zur Transaktionsberechnung (Einnahmen vs. Ausgaben) -->
            <div class="chart-container" id="chartContainer" style="display: none;">
                <h2>Einnahmen vs. Ausgaben</h2>
                <div>
                    {!! $chart->container() !!}
                    {!! $chart->script() !!}
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('mitgliederChartContainer').style.display = 'block';
                document.getElementById('chartContainer').style.display = 'block';
            }, 100);
        });
    </script>
@endsection
