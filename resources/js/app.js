import './bootstrap';

import {
    Chart,
    LineController,
    LineElement,
    PointElement,
    BarController,
    BarElement,
    LinearScale,
    CategoryScale,
    Filler,
    Tooltip,
    Legend,
} from 'chart.js';

Chart.register(
    LineController,
    LineElement,
    PointElement,
    BarController,
    BarElement,
    LinearScale,
    CategoryScale,
    Filler,
    Tooltip,
    Legend,
);

const palette = [
    '#2563eb',
    '#0f766e',
    '#dc2626',
    '#9333ea',
    '#ca8a04',
    '#0891b2',
    '#be123c',
    '#16a34a',
];

function parseData(value, fallback = []) {
    try {
        return JSON.parse(value || '[]');
    } catch {
        return fallback;
    }
}

function moneyTick(value) {
    return `PHP ${Number(value).toLocaleString(undefined, {
        maximumFractionDigits: 0,
    })}`;
}

function createLineChart(canvas, datasets, labels) {
    const context = canvas.getContext('2d');

    return new Chart(context, {
        type: 'line',
        data: {
            labels,
            datasets,
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: datasets.length > 1,
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 8,
                        color: '#475569',
                        font: {
                            weight: 700,
                        },
                    },
                },
                tooltip: {
                    callbacks: {
                        label: (item) => `${item.dataset.label}: ${moneyTick(item.parsed.y)}`,
                    },
                },
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        color: '#64748b',
                        font: {
                            weight: 700,
                        },
                    },
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(148, 163, 184, 0.22)',
                    },
                    ticks: {
                        color: '#64748b',
                        callback: moneyTick,
                    },
                },
            },
            elements: {
                line: {
                    borderWidth: 3,
                    tension: 0.35,
                },
                point: {
                    radius: 4,
                    hoverRadius: 6,
                    borderWidth: 2,
                    backgroundColor: '#ffffff',
                },
            },
        },
    });
}

function createAttendanceStatusChart(canvas, labels, values) {
    return new Chart(canvas.getContext('2d'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: canvas.dataset.title || 'Attendance',
                data: values,
                backgroundColor: ['#16a34a', '#ca8a04', '#be123c'],
                borderRadius: 8,
                borderSkipped: false,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    callbacks: {
                        label: (item) => `${item.label}: ${item.parsed.y} record${item.parsed.y === 1 ? '' : 's'}`,
                    },
                },
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        color: '#64748b',
                        font: {
                            weight: 800,
                        },
                    },
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        color: '#64748b',
                    },
                    grid: {
                        color: 'rgba(148, 163, 184, 0.22)',
                    },
                },
            },
        },
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-time-picker]').forEach((input) => {
        const wrapper = document.createElement('div');
        wrapper.className = 'time-picker-shell';

        const trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.className = 'time-picker-trigger';
        trigger.setAttribute('aria-expanded', 'false');
        trigger.innerHTML = `
            <span class="clock-face" aria-hidden="true">
                <span class="clock-hand hour"></span>
                <span class="clock-hand minute"></span>
            </span>
            <span class="time-picker-value">Select time</span>
        `;

        const panel = document.createElement('div');
        panel.className = 'time-picker-panel';
        panel.innerHTML = `
            <div class="time-picker-grid">
                <label>
                    <span>Hour</span>
                    <select class="time-hour"></select>
                </label>
                <label>
                    <span>Minute</span>
                    <select class="time-minute"></select>
                </label>
                <label>
                    <span>Period</span>
                    <select class="time-period">
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </label>
            </div>
            <div class="time-picker-actions">
                <button type="button" class="btn btn-secondary time-clear">Clear</button>
                <button type="button" class="btn time-apply">Apply</button>
            </div>
        `;

        input.classList.add('time-picker-native');
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);
        wrapper.appendChild(trigger);
        wrapper.appendChild(panel);

        const hourSelect = panel.querySelector('.time-hour');
        const minuteSelect = panel.querySelector('.time-minute');
        const periodSelect = panel.querySelector('.time-period');
        const valueLabel = trigger.querySelector('.time-picker-value');
        const hourHand = trigger.querySelector('.clock-hand.hour');
        const minuteHand = trigger.querySelector('.clock-hand.minute');

        for (let hour = 1; hour <= 12; hour += 1) {
            hourSelect.add(new Option(String(hour).padStart(2, '0'), hour));
        }

        for (let minute = 0; minute < 60; minute += 5) {
            minuteSelect.add(new Option(String(minute).padStart(2, '0'), minute));
        }

        const setClock = (hours24, minutes) => {
            const hourAngle = ((hours24 % 12) * 30) + (minutes * 0.5);
            const minuteAngle = minutes * 6;
            hourHand.style.transform = `translateX(-50%) rotate(${hourAngle}deg)`;
            minuteHand.style.transform = `translateX(-50%) rotate(${minuteAngle}deg)`;
        };

        const updateDisplay = () => {
            if (!input.value) {
                valueLabel.textContent = 'Select time';
                setClock(10, 10);
                return;
            }

            const [hours, minutes] = input.value.split(':').map(Number);
            const period = hours >= 12 ? 'PM' : 'AM';
            const displayHour = hours % 12 || 12;

            valueLabel.textContent = `${String(displayHour).padStart(2, '0')}:${String(minutes).padStart(2, '0')} ${period}`;
            setClock(hours, minutes);
        };

        const syncSelects = () => {
            const currentValue = input.value || '08:00';
            const [hours, minutes] = currentValue.split(':').map(Number);
            hourSelect.value = String(hours % 12 || 12);
            minuteSelect.value = String(Math.round(minutes / 5) * 5 % 60);
            periodSelect.value = hours >= 12 ? 'PM' : 'AM';
        };

        const closePanel = () => {
            wrapper.classList.remove('open');
            trigger.setAttribute('aria-expanded', 'false');
        };

        trigger.addEventListener('click', () => {
            const willOpen = !wrapper.classList.contains('open');
            document.querySelectorAll('.time-picker-shell.open').forEach((openPicker) => {
                openPicker.classList.remove('open');
                openPicker.querySelector('.time-picker-trigger')?.setAttribute('aria-expanded', 'false');
            });
            wrapper.classList.toggle('open', willOpen);
            trigger.setAttribute('aria-expanded', String(willOpen));
            syncSelects();
        });

        panel.querySelector('.time-apply').addEventListener('click', () => {
            let hour = Number(hourSelect.value);
            const minute = Number(minuteSelect.value);

            if (periodSelect.value === 'PM' && hour !== 12) {
                hour += 12;
            }

            if (periodSelect.value === 'AM' && hour === 12) {
                hour = 0;
            }

            input.value = `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
            input.dispatchEvent(new Event('change', { bubbles: true }));
            updateDisplay();
            closePanel();
        });

        panel.querySelector('.time-clear').addEventListener('click', () => {
            input.value = '';
            input.dispatchEvent(new Event('change', { bubbles: true }));
            updateDisplay();
            closePanel();
        });

        document.addEventListener('click', (event) => {
            if (!wrapper.contains(event.target)) {
                closePanel();
            }
        });

        updateDisplay();
    });

    document.querySelectorAll('.salary-line-chart').forEach((canvas) => {
        const labels = parseData(canvas.dataset.labels);
        const values = parseData(canvas.dataset.values);
        const color = canvas.dataset.color || '#2563eb';

        createLineChart(canvas, [{
            label: canvas.dataset.title || 'Net salary',
            data: values,
            borderColor: color,
            backgroundColor: 'rgba(37, 99, 235, 0.12)',
            fill: true,
        }], labels);
    });

    document.querySelectorAll('.attendance-status-chart').forEach((canvas) => {
        createAttendanceStatusChart(
            canvas,
            parseData(canvas.dataset.labels),
            parseData(canvas.dataset.values),
        );
    });

    document.querySelectorAll('.salary-multi-line-chart').forEach((canvas) => {
        const series = parseData(canvas.dataset.series);
        const labels = [...new Set(series.flatMap((item) => item.labels || []))].sort();

        const datasets = series.map((item, index) => {
            const points = new Map((item.labels || []).map((label, pointIndex) => [
                label,
                item.values?.[pointIndex] ?? null,
            ]));
            const color = palette[index % palette.length];

            return {
                label: item.name || `Employee ${index + 1}`,
                data: labels.map((label) => points.get(label) ?? null),
                borderColor: color,
                backgroundColor: color,
                spanGaps: true,
                fill: false,
            };
        });

        createLineChart(canvas, datasets, labels);
    });
});
