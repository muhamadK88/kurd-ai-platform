/** KURD AI production Tailwind build — replaces the Play CDN (runtime compiler). */
export default {
    darkMode: 'class',
    content: [
        './resources/views/**/*.blade.php',
        './public/js/**/*.js',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['"Noto Sans Arabic"', 'sans-serif'],
            },
            animation: {
                blob: 'blob 7s infinite',
                'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                float: 'float 6s ease-in-out infinite',
                'fade-up': 'fadeUp 0.6s ease-out',
                'fade-in': 'fadeIn 0.8s ease-out',
                'slide-up': 'slideUp 0.5s ease-out',
            },
            keyframes: {
                blob: {
                    '0%': { transform: 'translate(0px, 0px) scale(1)' },
                    '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                    '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                    '100%': { transform: 'translate(0px, 0px) scale(1)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-20px)' },
                },
                fadeUp: {
                    '0%': { opacity: '0', transform: 'translateY(30px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
        },
    },
    corePlugins: {
        preflight: true,
    },
};
