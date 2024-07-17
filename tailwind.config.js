import colors from 'tailwindcss/colors'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'

export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        './vendor/filament/**/*.blade.php',
        './app/Filament/**/*.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            spacing: {
                '22': '5.5rem',
                '35': '8.75rem',
            },
            fontSize: {
                'xss': '.6875rem',
                'xxs': '.65rem',
            },
            bottom: {
                '18': '4.5rem',
            },
            colors: {
                slate: {
                    ...colors.slate,
                    850: '#152033',
                },
                gray: colors.slate,
                danger: colors.rose,
                primary: colors.blue,
                success: colors.emerald,
                warning: colors.orange,
                customGreen: {
                    DEFAULT: '#116051',  // Color base
                    light: '#1b9e85',    // Variante mas clara
                    dark: '#0a382f',     // Variante mas oscura
                },
                customBlue: {
                    DEFAULT: '#28B5BE',  // Color base
                    light: '#4ec7d4',    // Variante mas clara
                    dark: '#1b8790',     // Variante mas oscura
                },
                customBlack: {
                    DEFAULT: '#2C2F33', // Color base
                    light: '#313438',   // Variante mas clara 
                    dark: '#1D2025',   // Variante mas oscura 
                },
                customCyan: {
                    DEFAULT: '#ab7c13', // Color base
                    light: '#DC9E18',   // Variante más clara
                    dark: '#936A10',    // Variante más oscura
                },
                customPurple: {
                    DEFAULT: '#ACA885', // Color base
                    light: '#BDBA9E',   // Variante más clara
                    dark: '#9C976D',    // Variante más oscura
                }
            }
        },
    },
    plugins: [
        forms,
        typography,
    ],
}
