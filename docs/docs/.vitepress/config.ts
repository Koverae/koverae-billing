import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
//   appearance: 'force-dark',
  base: '/koverae-billing/',
  title: "Koverae Billing",
  description: "Documentation for koverae billing package",
  head: [
    ['link', { rel: 'icon', href: '/koverae-billing/favicon.ico?v=2' }]
  ],
  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    logo: '/logo.png',

    nav: [

      { text: 'Home', link: '/' },
      { text: 'Guide', link: '/guide/introduction/' },
      { text: 'Issues', link: 'https://github.com/Koverae/koverae-billing/issues' },
      { text: 'Discussions', link: 'https://github.com/Koverae/koverae-billing/discussions' },
      { text: 'Donate', link: 'https://opencollective.com/laravel-wallet' },
      {
        text: 'v2',
        items: [
          {
            text: 'v1',
            link: 'https://koverae.github.io/koverae-billing/v1.x/getting-started.html'
          }
        ]
      },
    ],

    search: {
      provider: 'local',
    },


    sidebar: [
        {
          text: 'Getting started',
          items: [
            { text: 'Introduction', link: '/guide/introduction/' },
            { text: 'Installation', link: '/guide/introduction/installation' },
            { text: 'Configuration', link: '/guide/introduction/configuration' },
            { text: 'Basic Usage', link: '/guide/introduction/basic-usage' },
            { text: 'Upgrade', link: '/guide/introduction/upgrade' },
          ],
          collapsed: false,
        },
        {
          text: 'Single/Default Wallet',
          items: [
            { text: 'Deposit', link: '/guide/single/deposit' },
            { text: 'Withdraw', link: '/guide/single/withdraw' },
            { text: 'Transfer', link: '/guide/single/transfer' },
            { text: 'Refresh Balance', link: '/guide/single/refresh' },
            { text: 'Confirm Transaction', link: '/guide/single/confirm' },
            { text: 'Cancel Transaction', link: '/guide/single/cancel' },
            { text: 'Exchange', link: '/guide/single/exchange' },
            { text: 'Credit Limits', link: '/guide/single/credit-limits' },
          ],
          collapsed: false,
        },
        {
          text: 'Multi Wallet',
          items: [
            { text: 'New Wallet', link: '/guide/multi/new-wallet' },
            { text: 'Transfer', link: '/guide/multi/transfer' },
            { text: 'Transaction Filter', link: '/guide/multi/transaction-filter' },
          ],
          collapsed: false,
        },
        {
          text: 'Fractional Wallet',
          items: [
            { text: 'Deposit', link: '/guide/fractional/deposit' },
            { text: 'Withdraw', link: '/guide/fractional/withdraw' },
            { text: 'Transfer', link: '/guide/fractional/transfer' },
          ],
          collapsed: false,
        },
        {
          text: 'Purchases',
          items: [
            { text: 'Payment', link: '/guide/purchases/payment' },
            { text: 'Payment Free', link: '/guide/purchases/payment-free' },
            { text: 'Refund', link: '/guide/purchases/refund' },
            { text: 'Gift', link: '/guide/purchases/gift' },
            { text: 'Cart', link: '/guide/purchases/cart' },
            { text: 'Commissions', link: '/guide/purchases/commissions' },
            { text: 'Customize receiving', link: '/guide/purchases/receiving' },
          ],
          collapsed: false,
        },
        {
          text: 'Database Transaction',
          items: [
            { text: 'Atomic Service', link: '/guide/db/atomic-service' },
            { text: 'Race Condition', link: '/guide/db/race-condition' },
            { text: 'Transaction', link: '/guide/db/transaction' },
          ],
          collapsed: false,
        },
        {
          text: 'Events',
          items: [
            { text: 'Balance Updated', link: '/guide/events/balance-updated-event' },
            { text: 'Wallet Created', link: '/guide/events/wallet-created-event' },
            { text: 'Transaction Created', link: '/guide/events/transaction-created-event' },
            { text: 'Customize', link: '/guide/events/customize' },
          ],
          collapsed: false,
        },
        {
          text: 'Helpers',
          items: [
            { text: 'Formatter', link: '/guide/helpers/formatter' },
          ],
          collapsed: false,
        },
        {
          text: 'High performance api handles',
          items: [
            { text: 'Batch Transactions', link: '/guide/high-performance/batch-transactions' },
            { text: 'Batch Transfers', link: '/guide/high-performance/batch-transfers' },
          ],
          collapsed: false,
        },
        {
          text: 'CQRS',
          items: [
            { text: 'Create Wallet', link: '/guide/cqrs/create-wallet' },
          ],
          collapsed: false,
        },
        {
          text: 'Additions',
          items: [
            { text: 'Wallet Swap', link: '/guide/additions/swap' },
            { text: 'Support UUID', link: '/guide/additions/uuid' },
          ],
          collapsed: false,
        },
      ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/021-projects/laravel-wallet' },
      {
        icon: {
          svg: '<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><title>telegram</title> <path d="M22.122 10.040c0.006-0 0.014-0 0.022-0 0.209 0 0.403 0.065 0.562 0.177l-0.003-0.002c0.116 0.101 0.194 0.243 0.213 0.403l0 0.003c0.020 0.122 0.031 0.262 0.031 0.405 0 0.065-0.002 0.129-0.007 0.193l0-0.009c-0.225 2.369-1.201 8.114-1.697 10.766-0.21 1.123-0.623 1.499-1.023 1.535-0.869 0.081-1.529-0.574-2.371-1.126-1.318-0.865-2.063-1.403-3.342-2.246-1.479-0.973-0.52-1.51 0.322-2.384 0.221-0.23 4.052-3.715 4.127-4.031 0.004-0.019 0.006-0.040 0.006-0.062 0-0.078-0.029-0.149-0.076-0.203l0 0c-0.052-0.034-0.117-0.053-0.185-0.053-0.045 0-0.088 0.009-0.128 0.024l0.002-0.001q-0.198 0.045-6.316 4.174c-0.445 0.351-1.007 0.573-1.619 0.599l-0.006 0c-0.867-0.105-1.654-0.298-2.401-0.573l0.074 0.024c-0.938-0.306-1.683-0.467-1.619-0.985q0.051-0.404 1.114-0.827 6.548-2.853 8.733-3.761c1.607-0.853 3.47-1.555 5.429-2.010l0.157-0.031zM15.93 1.025c-8.302 0.020-15.025 6.755-15.025 15.060 0 8.317 6.742 15.060 15.060 15.060s15.060-6.742 15.060-15.060c0-8.305-6.723-15.040-15.023-15.060h-0.002q-0.035-0-0.070 0z"></path></svg>'
        },
        link: 'https://t.me/laravelwallet',
        ariaLabel: 'Telegram Group'
      },
      {
        icon: {
          svg: '<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.77791 3.65484C3.59687 4.01573 3.50783 4.46093 3.32975 5.35133L2.73183 8.34093C2.35324 10.2339 3.8011 12 5.73155 12C7.30318 12 8.61911 10.8091 8.77549 9.24527L8.8445 8.55515C8.68141 10.4038 10.1385 12 11.9998 12C13.8737 12 15.338 10.382 15.1515 8.51737L15.2245 9.24527C15.3809 10.8091 16.6968 12 18.2685 12C20.1989 12 21.6468 10.2339 21.2682 8.34093L20.6703 5.35133C20.4922 4.46095 20.4031 4.01573 20.2221 3.65484C19.8406 2.89439 19.1542 2.33168 18.3337 2.10675C17.9443 2 17.4903 2 16.5823 2H14.4998H7.41771C6.50969 2 6.05567 2 5.66628 2.10675C4.84579 2.33168 4.15938 2.89439 3.77791 3.65484Z" /><path d="M18.2685 13.5C19.0856 13.5 19.8448 13.2876 20.5 12.9189V14C20.5 17.7712 20.5 19.6568 19.3284 20.8284C18.3853 21.7715 16.9796 21.9554 14.5 21.9913V18.5C14.5 17.5654 14.5 17.0981 14.299 16.75C14.1674 16.522 13.978 16.3326 13.75 16.201C13.4019 16 12.9346 16 12 16C11.0654 16 10.5981 16 10.25 16.201C10.022 16.3326 9.83261 16.522 9.70096 16.75C9.5 17.0981 9.5 17.5654 9.5 18.5V21.9913C7.02043 21.9554 5.61466 21.7715 4.67157 20.8284C3.5 19.6568 3.5 17.7712 3.5 14V12.9189C4.15524 13.2876 4.91439 13.5 5.73157 13.5C6.92864 13.5 8.02617 13.0364 8.84435 12.2719C9.67168 13.0321 10.7765 13.5 11.9998 13.5C13.2232 13.5 14.3281 13.032 15.1555 12.2717C15.9737 13.0363 17.0713 13.5 18.2685 13.5Z" /></svg>'
        },
        link: 'https://devsell.io',
        ariaLabel: 'Add-ons & Services'
      }
    ]
  },
})
