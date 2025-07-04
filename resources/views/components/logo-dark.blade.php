@props([
    'width' => 400,
    'height' => 160,
])

<svg {{ $attributes }} width="{{ $width }}" height="{{ $height }}" viewBox="0 0 400 160"
    xmlns="http://www.w3.org/2000/svg" style="display: block;">

    <!-- Pest insect shape behind (larger and lighter) -->
    <g opacity="0.25" transform="translate(20,10) scale(1.4)">
        <ellipse cx="110" cy="90" rx="30" ry="50" fill="#4CAF50" />
        <!-- Legs (8 total) -->
        <line x1="75" y1="75" x2="50" y2="55" stroke="#A5D6A7" stroke-width="6" />
        <line x1="75" y1="90" x2="50" y2="90" stroke="#A5D6A7" stroke-width="6" />
        <line x1="75" y1="105" x2="50" y2="125" stroke="#A5D6A7" stroke-width="6" />
        <line x1="75" y1="120" x2="50" y2="140" stroke="#A5D6A7" stroke-width="6" />

        <line x1="145" y1="75" x2="170" y2="55" stroke="#A5D6A7" stroke-width="6" />
        <line x1="145" y1="90" x2="170" y2="90" stroke="#A5D6A7" stroke-width="6" />
        <line x1="145" y1="105" x2="170" y2="125" stroke="#A5D6A7" stroke-width="6" />
        <line x1="145" y1="120" x2="170" y2="140" stroke="#A5D6A7" stroke-width="6" />

        <!-- Antennae (2 front vitae) -->
        <line x1="95" y1="45" x2="85" y2="25" stroke="#A5D6A7" stroke-width="4" />
        <line x1="125" y1="45" x2="135" y2="25" stroke="#A5D6A7" stroke-width="4" />

        <circle cx="110" cy="60" r="10" fill="#A5D6A7" />
    </g>

    <defs>
        <!-- Red metallic gradient for shield (darker for dark mode) -->
        <linearGradient id="redMetal" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0%" stop-color="#5B0000" />
            <stop offset="40%" stop-color="#7F0B0B" />
            <stop offset="70%" stop-color="#4C0000" />
            <stop offset="100%" stop-color="#2F0000" />
        </linearGradient>

        <!-- Inner shadow gradient -->
        <radialGradient id="innerShadow" cx="50%" cy="50%" r="70%" fx="50%" fy="50%">
            <stop offset="80%" stop-color="black" stop-opacity="0.7" />
            <stop offset="100%" stop-color="black" stop-opacity="0" />
        </radialGradient>
    </defs>

    <!-- Shield base with red metallic gradient -->
    <path d="M80 20 L140 20 L180 60 L180 110 C180 140 140 160 110 160 C80 160 40 140 40 110 L40 60 Z"
        fill="url(#redMetal)" stroke="#3B0000" stroke-width="3" />

    <!-- Inner shadow overlay for aged metal effect -->
    <path d="M80 20 L140 20 L180 60 L180 110 C180 140 140 160 110 160 C80 160 40 140 40 110 L40 60 Z"
        fill="url(#innerShadow)" />

    <!-- Bug silhouette on shield (front smaller with legs & antennae) -->
    <ellipse cx="110" cy="90" rx="15" ry="25" fill="#FFC107" stroke="#FFB300"
        stroke-width="3" />

    <!-- Legs 8 -->
    <line x1="95" y1="75" x2="80" y2="60" stroke="#FFB300" stroke-width="3" />
    <line x1="95" y1="85" x2="80" y2="85" stroke="#FFB300" stroke-width="3" />
    <line x1="95" y1="95" x2="80" y2="105" stroke="#FFB300" stroke-width="3" />
    <line x1="95" y1="110" x2="80" y2="125" stroke="#FFB300" stroke-width="3" />

    <line x1="125" y1="75" x2="140" y2="60" stroke="#FFB300" stroke-width="3" />
    <line x1="125" y1="85" x2="140" y2="85" stroke="#FFB300" stroke-width="3" />
    <line x1="125" y1="95" x2="140" y2="105" stroke="#FFB300" stroke-width="3" />
    <line x1="125" y1="110" x2="140" y2="125" stroke="#FFB300" stroke-width="3" />

    <!-- Antennae (2 front vitae) -->
    <line x1="95" y1="55" x2="85" y2="40" stroke="#FFB300" stroke-width="2" />
    <line x1="125" y1="55" x2="135" y2="40" stroke="#FFB300" stroke-width="2" />

    <circle cx="110" cy="60" r="5" fill="#FFB300" />

    <!-- Text -->
    <text x="200" y="65" font-family="Poppins, sans-serif" font-weight="700" font-size="28" fill="#E0E0E0">
        National Pest
    </text>
    <text x="200" y="90" font-family="Poppins, sans-serif" font-weight="700" font-size="20" fill="#B0B0B0">
        Surveillance System
    </text>
    <text x="200" y="110" font-family="Poppins, sans-serif" font-weight="400" font-size="10" fill="#B0B0B0">
        National Plant Protection Service
    </text>
</svg>
