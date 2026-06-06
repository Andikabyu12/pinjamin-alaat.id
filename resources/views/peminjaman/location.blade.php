@extends('layouts.app')

@php
    $googleMapsApiKey = config('services.google.maps_api_key');
    $useGoogleMaps = !empty($googleMapsApiKey);
@endphp

@section('content')
<div class="min-h-screen py-12 relative overflow-hidden">
    <div class="container mx-auto px-4 relative z-10">
        <div class="enhanced-card rounded-3xl bg-gradient-to-br from-slate-900/90 via-slate-900/85 to-slate-950/90 border border-cyan-500/30 p-10 shadow-2xl mb-10 overflow-hidden">
            <div class="absolute inset-0 opacity-40 pointer-events-none">
                <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-cyan-400/20 to-transparent rounded-full blur-3xl -mr-32 -mt-32"></div>
            </div>
            <div class="relative z-10 flex flex-col gap-4">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <div>
                        <h1 class="text-4xl font-black text-white flex items-center gap-3"><i class="fas fa-map-marker-alt text-cyan-400"></i>Pilih Lokasi Peminjaman</h1>
                        <p class="mt-3 text-slate-300 max-w-2xl">Peta besar untuk menandai lokasi Anda. Setelah lokasi dipilih, tekan tombol Set Lokasi untuk kembali ke form peminjaman.</p>
                    </div>
                    <x-back-link fallback="{{ route('peminjaman.create', ['alat_id' => $alat_id]) }}" class="inline-flex items-center rounded-2xl bg-slate-700/50 border border-slate-600 hover:border-slate-500 px-6 py-3 text-white font-semibold transition-all duration-300 hover:bg-slate-700">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Form
                    </x-back-link>
                </div>
                <div class="rounded-3xl overflow-hidden border border-slate-800 shadow-2xl bg-slate-950/90" style="min-height: 70vh;">
                    <div id="locationMap" class="h-full w-full" style="min-height: 70vh;"></div>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="rounded-2xl border border-slate-700/50 bg-slate-900/80 p-4 text-slate-200">
                        <p class="font-semibold">Petunjuk:</p>
                        <ul class="list-disc list-inside mt-3 space-y-2 text-sm text-slate-300">
                            <li>Gunakan lokasi Anda saat ini atau klik pada peta untuk memilih titik lain.</li>
                            <li>Tekan tombol "Set Lokasi" setelah koordinat muncul.</li>
                            <li>Lokasi akan dibawa kembali ke form peminjaman.</li>
                        </ul>
                    </div>
                    <div class="rounded-2xl border border-slate-700/50 bg-slate-900/80 p-4 text-slate-200">
                        <p class="font-semibold">Lokasi terpilih</p>
                        <p class="mt-3 text-sm text-slate-400" id="coordsText">Belum ada koordinat terpilih.</p>
                        <p class="mt-2 text-sm text-slate-400" id="statusText">Menunggu lokasi.</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-4 items-center">
                    <button type="button" id="setLocationBtn" disabled class="inline-flex items-center rounded-2xl bg-emerald-500 px-6 py-3 text-white font-semibold transition hover:bg-emerald-400 disabled:opacity-50 disabled:cursor-not-allowed gap-2">
                        <i class="fas fa-location-arrow"></i>Set Lokasi
                    </button>
                    <button type="button" id="retryLocation" class="inline-flex items-center rounded-2xl bg-blue-600 px-6 py-3 text-white font-semibold transition hover:bg-blue-500 gap-2">
                        <i class="fas fa-sync-alt"></i>Perbarui Lokasi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-sA+e2kX0kGq7r3qkXf3p3kYQ5mA0mN1p2s9+Qv+0wYw=" crossorigin="" />
@if($useGoogleMaps)
    <script src="https://maps.googleapis.com/maps/api/js?key={{ $googleMapsApiKey }}&callback=initGoogleMaps" async defer></script>
@endif
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-QV1oVb6vJb6wqF0sQYb3Z1jv8Y+I6k2h2GZf3x0JwY0=" crossorigin=""></script>
<script>
    const alatId = @json($alat_id);
    const borrowDate = @json($borrow_date);
    const returnDate = @json($return_date);
    const useGoogleMaps = @json($useGoogleMaps);
    let selectedLat = null;
    let selectedLng = null;
    let map = null;
    let marker = null;
    let pendingPosition = null;
    let googleMapsReady = false;

    function updateStatus(message){
        document.getElementById('statusText').textContent = message;
    }

    function updateCoords(lat, lng, accuracy){
        selectedLat = lat;
        selectedLng = lng;
        document.getElementById('coordsText').textContent = `Lat: ${lat.toFixed(6)} | Lng: ${lng.toFixed(6)} | Akurasi: ${accuracy ? accuracy.toFixed(0) + ' m' : 'N/A'}`;
        document.getElementById('setLocationBtn').disabled = false;
    }

    function moveMarker(lat, lng){
        if (!map) return;

        if (useGoogleMaps && window.google && window.google.maps) {
            const position = { lat, lng };
            if (!marker) {
                marker = new google.maps.Marker({ position, map, draggable: true });
                marker.addListener('dragend', function() {
                    const pos = marker.getPosition();
                    updateCoords(pos.lat(), pos.lng(), null);
                    updateStatus('Koordinat diperbarui melalui drag marker.');
                });
            } else {
                marker.setPosition(position);
            }
            map.panTo(position);
            map.setZoom(15);
            return;
        }

        if (!marker) {
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('move', function(e){
                const pos = e.latlng;
                updateCoords(pos.lat, pos.lng, null);
                updateStatus('Koordinat diperbarui melalui drag marker.');
            });
        } else {
            marker.setLatLng([lat, lng]);
        }
        map.setView([lat, lng], 15);
    }

    function initLeaflet(lat = -6.200000, lng = 106.816666) {
        map = L.map('locationMap', { scrollWheelZoom: true }).setView([lat, lng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        L.circle([lat, lng], { radius: 200000, color: '#38bdf8', fillColor: '#38bdf8', fillOpacity: 0.08, weight: 2, dashArray: '6,8' }).addTo(map);
        moveMarker(lat, lng);

        map.on('click', function(e){
            const { lat, lng } = e.latlng;
            moveMarker(lat, lng);
            updateCoords(lat, lng, null);
            updateStatus('Lokasi dipilih dari peta. Klik Set Lokasi untuk menerapkannya.');
        });
    }

    function initGoogleMaps() {
        googleMapsReady = true;
        const defaultPosition = { lat: -6.200000, lng: 106.816666 };
        const initialPos = pendingPosition || defaultPosition;
        map = new google.maps.Map(document.getElementById('locationMap'), {
            center: initialPos,
            zoom: 13,
            mapTypeControl: false,
            streetViewControl: false,
        });

        if (pendingPosition) {
            moveMarker(pendingPosition.lat, pendingPosition.lng);
            pendingPosition = null;
        } else {
            moveMarker(initialPos.lat, initialPos.lng);
        }

        map.addListener('click', function(e) {
            const lat = e.latLng.lat();
            const lng = e.latLng.lng();
            moveMarker(lat, lng);
            updateCoords(lat, lng, null);
            updateStatus('Lokasi dipilih dari Google Maps. Klik Set Lokasi untuk menerapkannya.');
        });
    }

    function initMap(lat = -6.200000, lng = 106.816666) {
        if (useGoogleMaps) {
            if (!window.google || !window.google.maps) {
                pendingPosition = { lat, lng };
                return;
            }
            initGoogleMaps();
            return;
        }

        initLeaflet(lat, lng);
    }

    function chooseLocation(){
        if (!selectedLat || !selectedLng) return;
        const params = new URLSearchParams();
        if (alatId) params.set('alat_id', alatId);
        params.set('latitude', selectedLat);
        params.set('longitude', selectedLng);
        params.set('accuracy', 0);
        if (borrowDate) params.set('borrow_date', borrowDate);
        if (returnDate) params.set('return_date', returnDate);
        window.location.href = `{{ route('peminjaman.create') }}?${params.toString()}`;
    }

    function requestLocation(){
        if (!navigator.geolocation) {
            updateStatus('Geolocation tidak didukung browser. Silakan pilih dengan klik peta.');
            initMap();
            return;
        }
        updateStatus('Meminta izin lokasi...');
        navigator.geolocation.getCurrentPosition(function(pos){
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            const accuracy = pos.coords.accuracy;
            updateCoords(lat, lng, accuracy);
            initMap(lat, lng);
            updateStatus('Lokasi ditemukan. Klik Set Lokasi untuk kembali ke form.');
        }, function(err){
            updateStatus('Gagal mengambil lokasi: ' + err.message + '. Silakan klik peta untuk memilih lokasi.');
            initMap();
        }, { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 });
    }

    document.getElementById('setLocationBtn').addEventListener('click', chooseLocation);
    document.getElementById('retryLocation').addEventListener('click', requestLocation);

    requestLocation();
</script>
@endsection