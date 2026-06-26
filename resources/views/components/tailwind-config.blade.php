<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    brand: {
                        50: '#fff7ed',
                        100: '#ffedd5',
                        200: '#fed7aa',
                        300: '#fdba74',
                        400: '#fb923c',
                        500: '#f97316',
                        600: '#ea580c',
                        700: '#c2410c',
                        800: '#9a3412',
                        900: '#7c2d12',
                        950: '#431407',
                    },
                    darkbg: {
                        700: '#2a2a30',
                        800: '#1e1e24',
                        900: '#121214',
                        950: '#09090b',
                    },
                },
                fontFamily: {
                    sans: ['Plus Jakarta Sans', 'sans-serif'],
                },
                animation: {
                    'fade-in': 'fadeIn 0.4s ease-out forwards',
                    'fade-in-up': 'fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                    'float': 'float 6s ease-in-out infinite',
                    'pulse-glow': 'pulseGlow 4s infinite alternate ease-in-out',
                },
                keyframes: {
                    fadeIn: {
                        '0%': { opacity: '0' },
                        '100%': { opacity: '1' },
                    },
                    fadeInUp: {
                        '0%': { opacity: '0', transform: 'translateY(16px)' },
                        '100%': { opacity: '1', transform: 'translateY(0)' },
                    },
                    float: {
                        '0%, 100%': { transform: 'translateY(0)' },
                        '50%': { transform: 'translateY(-20px)' },
                    },
                    pulseGlow: {
                        '0%': { opacity: '0.4', transform: 'scale(1)' },
                        '100%': { opacity: '0.8', transform: 'scale(1.1)' },
                    },
                },
            },
        },
    };
</script>
