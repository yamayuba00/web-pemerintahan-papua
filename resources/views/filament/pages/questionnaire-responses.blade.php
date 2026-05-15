<x-filament-panels::page>
    @php
        $stats = $this->getStatistics();
    @endphp

    <style>
        .qr-stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .qr-stat-card {
            border-radius: 12px;
            padding: 20px 24px;
        }

        .qr-stat-card--primary {
            background: #eef2ff;
            border: 1px solid #c7d2fe;
        }

        .qr-stat-card--success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
        }

        .qr-stat-card--warning {
            background: #fffbeb;
            border: 1px solid #fde68a;
        }

        .qr-stat-label {
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .qr-stat-card--primary .qr-stat-label {
            color: #6366f1;
        }

        .qr-stat-card--success .qr-stat-label {
            color: #059669;
        }

        .qr-stat-card--warning .qr-stat-label {
            color: #d97706;
        }

        .qr-stat-value {
            font-size: 28px;
            font-weight: 700;
        }

        .qr-stat-card--primary .qr-stat-value {
            color: #4338ca;
        }

        .qr-stat-card--success .qr-stat-value {
            color: #047857;
        }

        .qr-stat-card--warning .qr-stat-value {
            color: #b45309;
        }

        .qr-tabs {
            display: flex;
            gap: 4px;
            margin-bottom: 24px;
            background: #f3f4f6;
            padding: 4px;
            border-radius: 10px;
        }

        .qr-tab {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            color: #6b7280;
            background: transparent;
        }

        .qr-tab--active {
            background: #ffffff;
            color: #4338ca;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .qr-card {
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            margin-bottom: 16px;
            overflow: hidden;
        }

        .qr-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .qr-card-title {
            font-size: 14px;
            font-weight: 600;
            color: #18181B;
        }

        .qr-card-subtitle {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 2px;
        }

        .qr-card-badge {
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 500;
            background: #f3f4f6;
            color: #6b7280;
        }

        .qr-card-body {
            padding: 16px 20px;
        }

        .qr-bar-row {
            margin-bottom: 12px;
        }

        .qr-bar-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .qr-bar-label-text {
            font-size: 13px;
            font-weight: 500;
            color: #374151;
        }

        .qr-bar-label-value {
            font-size: 12px;
            color: #9ca3af;
        }

        .qr-bar-track {
            width: 100%;
            height: 8px;
            background: #f3f4f6;
            border-radius: 4px;
            overflow: hidden;
        }

        .qr-bar-fill--primary {
            height: 100%;
            background: #6366f1;
            border-radius: 4px;
        }

        .qr-bar-fill--warning {
            height: 100%;
            background: #f59e0b;
            border-radius: 4px;
        }

        .qr-rating-grid {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 24px;
            align-items: center;
        }

        .qr-rating-big {
            text-align: center;
            padding: 0 16px;
        }

        .qr-rating-big-value {
            font-size: 40px;
            font-weight: 700;
            color: #f59e0b;
        }

        .qr-rating-big-label {
            font-size: 11px;
            color: #9ca3af;
        }

        .qr-rating-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 6px;
        }

        .qr-rating-star-num {
            font-size: 12px;
            width: 14px;
            text-align: right;
            color: #9ca3af;
        }

        .qr-text-item {
            padding: 10px 14px;
            background: #f9fafb;
            border-radius: 8px;
            margin-bottom: 8px;
            border-left: 3px solid #6366f1;
            font-size: 13px;
            color: #374151;
        }

        .qr-response-header {
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #f3f4f6;
        }

        .qr-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 15px;
            flex-shrink: 0;
        }

        .qr-response-name {
            font-weight: 600;
            color: #18181B;
            font-size: 15px;
        }

        .qr-response-meta {
            font-size: 12px;
            color: #9ca3af;
        }

        .qr-response-badge {
            font-size: 11px;
            background: #ecfdf5;
            color: #059669;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 500;
            margin-left: auto;
        }

        .qr-answer-row {
            padding: 14px 0;
            border-bottom: 1px solid #f9fafb;
        }

        .qr-answer-row:last-child {
            border-bottom: none;
        }

        .qr-answer-question {
            font-size: 11px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .qr-answer-value {
            font-size: 14px;
            color: #18181B;
        }

        .qr-pill {
            display: inline-block;
            font-size: 12px;
            padding: 4px 12px;
            border-radius: 20px;
            margin-right: 6px;
            margin-bottom: 4px;
            font-weight: 500;
            background: #eef2ff;
            color: #4338ca;
        }

        .qr-chip {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            font-size: 13px;
            color: #374151;
        }

        .qr-star {
            font-size: 20px;
        }

        .qr-star--on {
            color: #f59e0b;
        }

        .qr-star--off {
            color: #e5e7eb;
        }

        .qr-empty {
            text-align: center;
            padding: 48px;
            color: #9ca3af;
            font-size: 14px;
        }

        /* Dark mode */
        .dark .qr-stat-card--primary {
            background: #18181B;
            border-color: #374151;
        }

        .dark .qr-stat-card--success {
            background: #18181B;
            border-color: #374151;
        }

        .dark .qr-stat-card--warning {
            background: #18181B;
            border-color: #374151;
        }

        .dark .qr-stat-card--primary .qr-stat-label {
            color: #9ca3af;
        }

        .dark .qr-stat-card--success .qr-stat-label {
            color: #9ca3af;
        }

        .dark .qr-stat-card--warning .qr-stat-label {
            color: #9ca3af;
        }

        .dark .qr-stat-card--primary .qr-stat-value {
            color: #f3f4f6;
        }

        .dark .qr-stat-card--success .qr-stat-value {
            color: #f3f4f6;
        }

        .dark .qr-stat-card--warning .qr-stat-value {
            color: #f3f4f6;
        }

        .dark .qr-tabs {
            background: #18181B;
        }

        .dark .qr-tab {
            color: #9ca3af;
        }

        .dark .qr-tab--active {
            background: #374151;
            color: #f3f4f6;
            box-shadow: none;
        }

        .dark .qr-card {
            border-color: #374151;
            background: #18181B;
        }

        .dark .qr-card-header {
            border-bottom-color: #374151;
        }

        .dark .qr-card-title {
            color: #f3f4f6;
        }

        .dark .qr-card-badge {
            background: #374151;
            color: #9ca3af;
        }

        .dark .qr-bar-label-text {
            color: #e5e7eb;
        }

        .dark .qr-bar-track {
            background: #374151;
        }

        .dark .qr-text-item {
            background: #18181B;
            color: #d1d5db;
            border-left-color: #4b5563;
        }

        .dark .qr-response-header {
            border-bottom-color: #374151;
        }

        .dark .qr-response-name {
            color: #f3f4f6;
        }

        .dark .qr-response-meta {
            color: #6b7280;
        }

        .dark .qr-response-badge {
            background: #18181B;
            color: #34d399;
            border: 1px solid #374151;
        }

        .dark .qr-answer-row {
            border-bottom-color: #374151;
        }

        .dark .qr-answer-question {
            color: #6b7280;
        }

        .dark .qr-answer-value {
            color: #e5e7eb;
        }

        .dark .qr-pill {
            background: #374151;
            color: #e5e7eb;
        }

        .dark .qr-chip {
            background: #18181B;
            border-color: #374151;
            color: #e5e7eb;
        }

        .dark .qr-star--off {
            color: #374151;
        }

        /* Table dark mode */
        .dark table {
            --border-color: #374151;
            --row-highlight: #18181B;
        }

        table {
            --border-color: #e5e7eb;
            --row-highlight: #f9fafb;
        }
    </style>

    <div x-data="{ tab: 'summary' }">

        {{-- Header Stats --}}
        <div class="qr-stats-grid">
            <div class="qr-stat-card qr-stat-card--primary">
                <div class="qr-stat-label">Total Responden</div>
                <div class="qr-stat-value">{{ $stats['total_responses'] }}</div>
            </div>
            <div class="qr-stat-card qr-stat-card--success">
                <div class="qr-stat-label">Jumlah Pertanyaan</div>
                <div class="qr-stat-value">{{ count($stats['questions']) }}</div>
            </div>
            <div class="qr-stat-card qr-stat-card--warning">
                <div class="qr-stat-label">
                    @if ($stats['scoring_type'] === 'skm')
                        Nilai IKM
                    @else
                        Rata-rata Kepuasan
                    @endif
                </div>
                <div class="qr-stat-value">
                    @if ($stats['ikm'])
                        {{ $stats['ikm'] }}
                        @if ($stats['mutu'])
                            <span style="font-size: 14px; font-weight: 500; color: {{ $stats['mutu']['color'] }};">
                                ({{ $stats['mutu']['grade'] }} - {{ $stats['mutu']['label'] }})
                            </span>
                        @endif
                    @else
                        -
                    @endif
                </div>
            </div>
        </div>

        {{-- Tab Buttons --}}
        <div class="qr-tabs">
            <button @click="tab = 'summary'" class="qr-tab" :class="tab === 'summary' && 'qr-tab--active'">
                📊 Ringkasan
            </button>
            <button @click="tab = 'chart'" class="qr-tab" :class="tab === 'chart' && 'qr-tab--active'">
                📈 Chart
            </button>
            <button @click="tab = 'skm'" class="qr-tab" :class="tab === 'skm' && 'qr-tab--active'">
                📋 Tabel SKM
            </button>
            <button @click="tab = 'responses'" class="qr-tab" :class="tab === 'responses' && 'qr-tab--active'">
                👥 Detail Responden ({{ $stats['total_responses'] }})
            </button>
        </div>

        {{-- TAB: Summary --}}
        <div x-show="tab === 'summary'">
            @forelse ($stats['questions'] as $question)
                <div class="qr-card">
                    <div class="qr-card-header">
                        <div>
                            <div class="qr-card-title">{{ $loop->iteration }}. {{ $question['question'] }}</div>
                            <div class="qr-card-subtitle">{{ $question['total_answers'] }} jawaban</div>
                        </div>
                        <span class="qr-card-badge">
                            @if ($question['type'] === 'rating')
                                ⭐ Rating
                            @elseif($question['type'] === 'dropdown')
                                📋 Dropdown
                            @elseif($question['type'] === 'checkbox')
                                ☑️ Checkbox
                            @elseif($question['type'] === 'radio')
                                🔘 Radio
                            @else
                                📝 Text
                            @endif
                        </span>
                    </div>
                    <div class="qr-card-body">
                        @if ($question['type'] === 'rating')
                            @php $maxScale = $question['summary']['max_scale'] ?? 4; @endphp
                            <div class="qr-rating-grid">
                                <div class="qr-rating-big">
                                    <div class="qr-rating-big-value">{{ $question['summary']['average'] }}</div>
                                    <div class="qr-rating-big-label">dari {{ $maxScale }}.0</div>
                                </div>
                                <div>
                                    @foreach ($question['summary']['distribution'] as $star => $count)
                                        @php $pct = $question['total_answers'] > 0 ? round(($count / $question['total_answers']) * 100, 1) : 0; @endphp
                                        <div class="qr-rating-row">
                                            <span class="qr-rating-star-num">{{ $star }}</span>
                                            <span style="font-size: 12px;">⭐</span>
                                            <div class="qr-bar-track" style="flex: 1;">
                                                <div class="qr-bar-fill--warning" style="width: {{ $pct }}%;">
                                                </div>
                                            </div>
                                            <span class="qr-bar-label-value"
                                                style="width: 60px; text-align: right;">{{ $count }}
                                                ({{ $pct }}%)</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @elseif (in_array($question['type'], ['dropdown', 'radio', 'checkbox']))
                            @forelse ($question['summary'] as $option => $count)
                                @php $pct = $question['total_answers'] > 0 ? round(($count / $question['total_answers']) * 100, 1) : 0; @endphp
                                <div class="qr-bar-row">
                                    <div class="qr-bar-label">
                                        <span class="qr-bar-label-text">{{ $option }}</span>
                                        <span class="qr-bar-label-value">{{ $count }}
                                            ({{ $pct }}%)</span>
                                    </div>
                                    <div class="qr-bar-track">
                                        <div class="qr-bar-fill--primary" style="width: {{ $pct }}%;"></div>
                                    </div>
                                </div>
                            @empty
                                <div class="qr-empty">Belum ada jawaban.</div>
                            @endforelse
                        @elseif ($question['type'] === 'text')
                            @if (!empty($question['summary']))
                                <div style="max-height: 200px; overflow-y: auto;">
                                    @foreach ($question['summary'] as $answer)
                                        <div class="qr-text-item">"{{ $answer }}"</div>
                                    @endforeach
                                </div>
                            @else
                                <div class="qr-empty">Belum ada jawaban.</div>
                            @endif
                        @endif
                    </div>
                </div>
            @empty
                <div class="qr-empty">Belum ada pertanyaan di kuesioner ini.</div>
            @endforelse
        </div>

        {{-- TAB: Chart --}}
        <div x-show="tab === 'chart'" x-cloak>
            <div class="qr-card">
                <div class="qr-card-header">
                    <div>
                        <div class="qr-card-title">Grafik NRR Per Unsur Pelayanan</div>
                        <div class="qr-card-subtitle">Nilai rata-rata per pertanyaan</div>
                    </div>
                </div>
                <div class="qr-card-body">
                    @php
                        $maxScale = $stats['max_scale'] ?? 4;
                    @endphp
                    @foreach ($stats['questions'] as $i => $question)
                        @if (in_array($question['type'], ['rating', 'radio', 'dropdown']))
                            @php
                                $nrr = $stats['nrr_per_unsur'][$i] ?? 0;
                                $pct = $maxScale > 0 ? round(($nrr / $maxScale) * 100, 1) : 0;
                                $color = $nrr >= ($maxScale * 0.75) ? '#10b981' : ($nrr >= ($maxScale * 0.5) ? '#f59e0b' : '#ef4444');
                            @endphp
                            <div style="margin-bottom: 16px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                    <span class="qr-bar-label-text">U{{ $i + 1 }}. {{ $question['question'] }}</span>
                                    <span class="qr-bar-label-value" style="font-weight: 600;">{{ number_format($nrr, 3, ',', '.') }} / {{ $maxScale }}</span>
                                </div>
                                <div class="qr-bar-track" style="height: 20px; border-radius: 6px;">
                                    <div style="height: 100%; background: {{ $color }}; border-radius: 6px; width: {{ $pct }}%; display: flex; align-items: center; justify-content: flex-end; padding-right: 8px;">
                                        <span style="font-size: 10px; color: white; font-weight: 600;">{{ $pct }}%</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    @if($stats['ikm'])
                        <div style="margin-top: 24px; padding: 16px; border-radius: 8px; background: var(--row-highlight, #f9fafb); text-align: center;">
                            <div style="font-size: 12px; color: #6b7280;">IKM Unit Pelayanan</div>
                            <div style="font-size: 32px; font-weight: 700; color: {{ $stats['mutu']['color'] ?? '#374151' }};">
                                {{ $stats['ikm'] }}
                            </div>
                            @if($stats['mutu'])
                                <div style="font-size: 14px; font-weight: 500; color: {{ $stats['mutu']['color'] }};">
                                    {{ $stats['mutu']['grade'] }} - {{ $stats['mutu']['label'] }}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- Distribusi per pertanyaan --}}
            @foreach ($stats['questions'] as $i => $question)
                @if (in_array($question['type'], ['radio', 'dropdown']) && !empty($question['summary']))
                    <div class="qr-card">
                        <div class="qr-card-header">
                            <div>
                                <div class="qr-card-title">U{{ $i + 1 }}. {{ $question['question'] }}</div>
                                <div class="qr-card-subtitle">Distribusi jawaban</div>
                            </div>
                        </div>
                        <div class="qr-card-body">
                            @foreach ($question['summary'] as $option => $count)
                                @php $pct = $question['total_answers'] > 0 ? round(($count / $question['total_answers']) * 100, 1) : 0; @endphp
                                <div style="margin-bottom: 10px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 3px;">
                                        <span class="qr-bar-label-text">{{ $option }}</span>
                                        <span class="qr-bar-label-value">{{ $count }} ({{ $pct }}%)</span>
                                    </div>
                                    <div class="qr-bar-track" style="height: 12px;">
                                        <div class="qr-bar-fill--primary" style="width: {{ $pct }}%; border-radius: 4px;"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        {{-- TAB: SKM Table --}}
        <div x-show="tab === 'skm'" x-cloak>
            {{-- Notif TTD Mode --}}
            @php
                $useDigitalSign = \App\Models\Settings::get('use_digital_signature');
            @endphp
            <div class="qr-card" style="margin-bottom: 12px; border-left: 3px solid {{ $useDigitalSign ? '#10b981' : '#f59e0b' }};">
                <div style="padding: 12px 20px; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 18px;">{{ $useDigitalSign ? '🔐' : '✍️' }}</span>
                        <div>
                            <div class="qr-card-title" style="font-size: 13px;">
                                Mode Tanda Tangan: <strong>{{ $useDigitalSign ? 'Digital (QR Code)' : 'Cap Basah (Manual)' }}</strong>
                            </div>
                            <div class="qr-card-subtitle">
                                {{ $useDigitalSign ? 'QR code akan otomatis muncul saat print dari NIP.' : 'Space kosong akan disediakan untuk tanda tangan manual.' }}
                            </div>
                        </div>
                    </div>
                    <a href="/admin/settings" class="qr-tab qr-tab--active" style="font-size: 12px; padding: 6px 14px; text-decoration: none;">
                        ⚙️ Ubah di Settings
                    </a>
                </div>
            </div>

            <div class="qr-card">
                <div class="qr-card-header">
                    <div>
                        <div class="qr-card-title">Pengolahan Data: {{ strtoupper($this->record->title) }}</div>
                        <div class="qr-card-subtitle">Per Responden dan Per Unsur Pelayanan</div>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <button wire:click="downloadCsv" class="qr-tab qr-tab--active"
                            style="font-size: 12px; padding: 6px 14px;">
                            ⬇️ CSV
                        </button>
                        <button onclick="printSKM()" class="qr-tab qr-tab--active"
                            style="font-size: 12px; padding: 6px 14px;">
                            🖨️ Print PDF
                        </button>
                    </div>
                </div>
                <div class="qr-card-body" style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                        <thead>
                            <tr>
                                <th style="padding: 8px 12px; text-align: center; border: 1px solid var(--border-color, #e5e7eb); font-weight: 600; width: 60px;"
                                    rowspan="2">NO.</th>
                                <th style="padding: 8px 12px; text-align: center; border: 1px solid var(--border-color, #e5e7eb); font-weight: 600;"
                                    colspan="{{ count($stats['question_labels']) }}">NILAI UNSUR PELAYANAN</th>
                            </tr>
                            <tr>
                                @foreach ($stats['question_labels'] as $i => $label)
                                    <th style="padding: 8px 12px; text-align: center; border: 1px solid var(--border-color, #e5e7eb); font-weight: 600;"
                                        title="{{ $label }}">U{{ $i + 1 }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stats['skm_table'] as $rIndex => $row)
                                <tr>
                                    <td
                                        style="padding: 6px 12px; text-align: center; border: 1px solid var(--border-color, #e5e7eb);">
                                        {{ $rIndex + 1 }}</td>
                                    @foreach ($row['values'] as $val)
                                        <td
                                            style="padding: 6px 12px; text-align: center; border: 1px solid var(--border-color, #e5e7eb);">
                                            {{ $val ?: '-' }}</td>
                                    @endforeach
                                </tr>
                            @endforeach

                            {{-- ΣNilai/Unsur --}}
                            <tr style="font-weight: 600; background: var(--row-highlight, #f9fafb);">
                                <td style="padding: 8px 12px; border: 1px solid var(--border-color, #e5e7eb);">
                                    ΣNilai/Unsur</td>
                                @foreach ($stats['unsur_totals'] as $total)
                                    <td
                                        style="padding: 8px 12px; text-align: center; border: 1px solid var(--border-color, #e5e7eb);">
                                        {{ $total }}</td>
                                @endforeach
                            </tr>

                            {{-- NRR/Unsur --}}
                            <tr style="font-weight: 600; background: var(--row-highlight, #f9fafb);">
                                <td style="padding: 8px 12px; border: 1px solid var(--border-color, #e5e7eb);">NRR/Unsur
                                </td>
                                @foreach ($stats['nrr_per_unsur'] as $nrr)
                                    <td
                                        style="padding: 8px 12px; text-align: center; border: 1px solid var(--border-color, #e5e7eb);">
                                        {{ number_format($nrr, 3, ',', '.') }}</td>
                                @endforeach
                            </tr>

                            {{-- NRR Tertimbang --}}
                            <tr style="font-weight: 600; background: var(--row-highlight, #f9fafb);">
                                <td style="padding: 8px 12px; border: 1px solid var(--border-color, #e5e7eb);">NRR
                                    Tertimbang/Unsur</td>
                                @foreach ($stats['nrr_tertimbang'] as $nrrt)
                                    <td
                                        style="padding: 8px 12px; text-align: center; border: 1px solid var(--border-color, #e5e7eb);">
                                        {{ number_format($nrrt, 3, ',', '.') }}</td>
                                @endforeach
                            </tr>

                            {{-- IKM --}}
                            <tr style="font-weight: 700;">
                                <td style="padding: 10px 12px; border: 1px solid var(--border-color, #e5e7eb);">IKM Unit
                                    Pelayanan</td>
                                <td colspan="{{ count($stats['question_labels']) }}"
                                    style="padding: 10px 12px; text-align: center; border: 1px solid var(--border-color, #e5e7eb); font-size: 16px;">
                                    {{ $stats['ikm'] ?? '-' }}
                                    @if ($stats['mutu'])
                                        <span style="color: {{ $stats['mutu']['color'] }}; margin-left: 8px;">
                                            ({{ $stats['mutu']['grade'] }} - {{ $stats['mutu']['label'] }})
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Keterangan --}}
                <div style="padding: 16px 20px; border-top: 1px solid var(--border-color, #e5e7eb); font-size: 12px;">
                    <div style="font-weight: 600; margin-bottom: 8px;">Keterangan:</div>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 4px;">
                        @foreach ($stats['question_labels'] as $i => $label)
                            <div><span style="font-weight: 500;">U{{ $i + 1 }}</span> = {{ $label }}
                            </div>
                        @endforeach
                    </div>
                    <div style="margin-top: 12px; color: #6b7280;">
                        <div>NRR = Jumlah nilai per unsur dibagi jumlah kuesioner yang terisi</div>
                        <div>NRR Tertimbang = NRR per unsur × {{ number_format($stats['bobot'], 3, ',', '.') }}</div>
                        <div>IKM = Jumlah NRR tertimbang × 25</div>
                    </div>
                    <div style="margin-top: 12px;">
                        <div style="font-weight: 600; margin-bottom: 4px;">Mutu Pelayanan:</div>
                        <div>A (Sangat Baik): 88,31 - 100,00 | B (Baik): 76,61 - 88,30 | C (Kurang Baik): 65,00 - 76,60
                            | D (Tidak Baik): 25,00 - 64,99</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB: Detail Responses --}}
        <div x-show="tab === 'responses'" x-cloak>
            @forelse ($stats['responses'] as $response)
                <div class="qr-card">
                    <div class="qr-response-header">
                        <div class="qr-avatar">{{ strtoupper(substr($response['name'], 0, 1)) }}</div>
                        <div style="flex: 1;">
                            <div class="qr-response-name">{{ $response['name'] }}</div>
                            <div class="qr-response-meta">
                                @if ($response['email'])
                                    {{ $response['email'] }} &bull;
                                @endif
                                {{ $response['date'] }}
                            </div>
                        </div>
                        <span class="qr-response-badge">✓ Selesai</span>
                    </div>
                    <div class="qr-card-body">
                        @foreach ($response['answers'] as $answer)
                            <div class="qr-answer-row">
                                <div class="qr-answer-question">{{ $answer['question'] }}</div>
                                <div class="qr-answer-value">
                                    @if ($answer['type'] === 'checkbox' && $answer['answer_array'])
                                        @foreach ($answer['answer_array'] as $item)
                                            <span class="qr-pill">✓ {{ $item }}</span>
                                        @endforeach
                                    @elseif ($answer['type'] === 'rating' && $answer['answer'])
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span
                                                class="qr-star {{ $i <= (int) $answer['answer'] ? 'qr-star--on' : 'qr-star--off' }}">★</span>
                                        @endfor
                                        <span
                                            style="color: #9ca3af; font-size: 12px; margin-left: 8px;">({{ $answer['answer'] }}/5)</span>
                                    @elseif ($answer['answer'])
                                        <span class="qr-chip">{{ $answer['answer'] }}</span>
                                    @else
                                        <span style="color: #9ca3af; font-style: italic; font-size: 12px;">Tidak
                                            dijawab</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="qr-card">
                    <div class="qr-empty">
                        <div style="font-size: 32px; margin-bottom: 8px;">👥</div>
                        Belum ada responden.
                    </div>
                </div>
            @endforelse
        </div>

    </div>

    {{-- Print Template (hidden) --}}
    <div id="skm-print-area" style="display: none;">
        <div style="font-family: 'Times New Roman', serif; padding: 20px; color: #000;">
            <h3 style="text-align: center; margin-bottom: 4px; font-size: 14px;">PENGOLAHAN DATA
                {{ strtoupper($this->record->title) }} PER RESPONDEN</h3>
            <h3 style="text-align: center; margin-bottom: 4px; font-size: 14px;">DAN PER UNSUR PELAYANAN</h3>

            <table style="width: 100%; border-collapse: collapse; font-size: 11px;">
                <thead>
                    <tr>
                        <th style="padding: 6px; text-align: center; border: 1px solid #000; font-weight: bold; width: 50px;"
                            rowspan="2">NO.</th>
                        <th style="padding: 6px; text-align: center; border: 1px solid #000; font-weight: bold;"
                            colspan="{{ count($stats['question_labels']) }}">NILAI UNSUR PELAYANAN</th>
                    </tr>
                    <tr>
                        @foreach ($stats['question_labels'] as $i => $label)
                            <th style="padding: 6px; text-align: center; border: 1px solid #000; font-weight: bold;">
                                U{{ $i + 1 }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stats['skm_table'] as $rIndex => $row)
                        <tr>
                            <td style="padding: 4px 6px; text-align: center; border: 1px solid #000;">
                                {{ $rIndex + 1 }}</td>
                            @foreach ($row['values'] as $val)
                                <td style="padding: 4px 6px; text-align: center; border: 1px solid #000;">
                                    {{ $val ?: '-' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                    <tr style="font-weight: bold;">
                        <td style="padding: 6px; border: 1px solid #000;">ΣNilai<br>/Unsur</td>
                        @foreach ($stats['unsur_totals'] as $total)
                            <td style="padding: 6px; text-align: center; border: 1px solid #000;">{{ $total }}
                            </td>
                        @endforeach
                    </tr>
                    <tr style="font-weight: bold;">
                        <td style="padding: 6px; border: 1px solid #000;">NRR<br>/Unsur</td>
                        @foreach ($stats['nrr_per_unsur'] as $nrr)
                            <td style="padding: 6px; text-align: center; border: 1px solid #000;">
                                {{ number_format($nrr, 3, ',', '.') }}</td>
                        @endforeach
                    </tr>
                    <tr style="font-weight: bold;">
                        <td style="padding: 6px; border: 1px solid #000;">NRR<br>Tertimba<br>ng<br>/Unsur</td>
                        @foreach ($stats['nrr_tertimbang'] as $i => $nrrt)
                            <td style="padding: 6px; text-align: center; border: 1px solid #000;">
                                {{ number_format($nrrt, 3, ',', '.') }}</td>
                        @endforeach
                    </tr>
                    <tr style="font-weight: bold;">
                        <td style="padding: 6px; border: 1px solid #000;">IKM Unit Pelayanan</td>
                        <td colspan="{{ count($stats['question_labels']) }}"
                            style="padding: 6px; text-align: center; border: 1px solid #000; font-size: 14px;">
                            {{ $stats['ikm'] ?? '-' }}
                            @if ($stats['mutu'])
                                ({{ $stats['mutu']['grade'] }} - {{ $stats['mutu']['label'] }})
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <div style="margin-top: 20px; font-size: 11px;">
                <p style="margin-bottom: 4px;"><strong>Keterangan:</strong></p>
                @foreach ($stats['question_labels'] as $i => $label)
                    <p style="margin: 2px 0;">U{{ $i + 1 }} = {{ $label }}</p>
                @endforeach
                <p style="margin-top: 10px;">NRR = Jumlah nilai per unsur dibagi jumlah kuesioner yang terisi</p>
                <p>NRR Tertimbang = NRR per unsur × {{ number_format($stats['bobot'], 3, ',', '.') }}</p>
                <p>IKM = Jumlah NRR tertimbang × 25</p>
                <p style="margin-top: 10px;"><strong>Mutu Pelayanan:</strong></p>
                <p>A (Sangat Baik): 88,31 - 100,00</p>
                <p>B (Baik): 76,61 - 88,30</p>
                <p>C (Kurang Baik): 65,00 - 76,60</p>
                <p>D (Tidak Baik): 25,00 - 64,99</p>
            </div>

            {{-- Tanda Tangan --}}
            @php
                $signerName = \App\Models\Settings::get('signer_name');
                $signerPosition = \App\Models\Settings::get('signer_position');
                $signerNip = \App\Models\Settings::get('signer_nip');
                $signLocation = \App\Models\Settings::get('sign_location');
                $useDigital = \App\Models\Settings::get('use_digital_signature');
            @endphp
            @if ($signerName)
                <div style="margin-top: -200px; display: flex; justify-content: flex-end;">
                    @if ($useDigital && $signerNip)
                        {{-- Format Digital: kotak dengan QR (dari NIP) + teks --}}
                        <div
                            style="border: 2px solid #000; padding: 12px; display: flex; align-items: center; gap: 14px; min-width: 300px;">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode($signerNip) }}"
                                style="width: 90px; height: 90px;" alt="QR">
                            <div style="text-align: left;">
                                <p style="margin: 0; font-size: 10px;">Ditandatangani secara elektronik oleh:</p>
                                @if ($signerPosition)
                                    <p style="margin: 4px 0 0; font-size: 11px; font-weight: bold;">
                                        {{ strtoupper($signerPosition) }}</p>
                                @endif
                                <p style="margin: 14px 0 0; font-size: 11px; font-weight: bold;">{{ $signerName }}
                                </p>
                                <p style="margin: 2px 0 0; font-size: 11px;">NIP. {{ $signerNip }}</p>

                            </div>
                        </div>
                    @else
                        {{-- Format Cap Basah: space kosong untuk TTD manual --}}
                        <div style="text-align: center; min-width: 280px;">
                            <p style="margin: 0; font-size: 11px;">
                                {{ $signLocation ? $signLocation . ', ' : '' }}{{ now()->translatedFormat('d F Y') }}
                            </p>
                            @if ($signerPosition)
                                <p style="margin: 4px 0 0; font-size: 11px;">{{ $signerPosition }}</p>
                            @endif
                            <div style="height: 70px;"></div>
                            <p style="margin: 0; font-size: 12px; font-weight: bold; text-decoration: underline;">
                                {{ $signerName }}</p>
                            @if ($signerNip)
                                <p style="margin: 2px 0 0; font-size: 11px;">NIP. {{ $signerNip }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function printSKM() {
                var printContent = document.getElementById('skm-print-area').innerHTML;
                var printWindow = window.open('', '_blank', 'width=900,height=700');
                printWindow.document.write('<html><head><title>{{ addslashes($this->record->title) }}<\/title>');
                printWindow.document.write(
                    '<style>body{font-family:"Times New Roman",serif;margin:0;padding:20px;}@media print{body{padding:0;}@page{margin:1.5cm;size:landscape;}}<\/style>'
                    );
                printWindow.document.write('<\/head><body>');
                printWindow.document.write(printContent);
                printWindow.document.write('<\/body><\/html>');
                printWindow.document.close();
                printWindow.focus();
                setTimeout(function() {
                    printWindow.print();
                }, 300);
            }
        </script>
    @endpush
</x-filament-panels::page>
