import { defineConfig } from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
  base: '/koverae-billing/',
  title: "Koverae Billing",
  description: "Documentation for koverae billing package",
  lastUpdated: true,
  head: [
    ['link', { rel: 'icon', href: 'https://github.com/bavix/laravel-wallet/assets/5111255/f48a8e79-8a9d-469a-b056-b3d04835992d' }]
  ],

  themeConfig: {
    // https://vitepress.dev/reference/default-theme-config
    search: {
        provider: 'local',
    },
    editLink: {
      pattern: 'https://github.com/Koverae/koverae-billing/tree/main/docs/docs/:path'
    },
    appearance: 'force-dark',
    logo: '/logo.png',
    favicon: '/logo.png',
    nav: [

      { text: 'Home', link: '/' },
      { text: 'Guide', link: '/guide/introduction/' },
      { text: 'Issues', link: 'https://github.com/Koverae/koverae-billing/issues' },
      { text: 'Discussions', link: 'https://github.com/Koverae/koverae-billing/discussions' },
    //   {
    //     text: 'v2',
    //     items: [
    //       {
    //         text: 'v1',
    //         link: 'https://koverae.github.io/koverae-billing/v1.x/getting-started.html'
    //       }
    //     ]
    //   },
    ],

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
          collapsed: true,
        },
        {
          text: 'Plans',
          items: [
            { text: 'How to Define Plans', link: '/guide/plans/plan' },
            { text: 'Plan Combination', link: '/guide/plans/combination' },
            { text: 'Plan Feature', link: '/guide/plans/feature' },
          ],
          collapsed: false,
        },
        {
          text: 'Subscriptions',
          items: [
            { text: 'Plan Subscription', link: '/guide/subscriptions/subscription' },
            { text: 'Subscription Features', link: '/guide/subscriptions/feature' },
            { text: 'Subscription Schedule', link: '/guide/subscriptions/schedule' },
            { text: 'Message Templates', link: '/guide/subscriptions/template' },
            { text: 'Reminder Service', link: '/guide/subscriptions/reminder' },
          ],
          collapsed: false,
        },
        {
          text: 'Payments',
          items: [
            { text: 'Payment Services', link: '/guide/payments/service' },
            { text: 'Payment Queuer', link: '/guide/payments/queuer' },
            { text: 'Renewal Payment', link: '/guide/payments/renewal' },
            { text: 'Schedule Payment', link: '/guide/payments/schedule' },
          ],
          collapsed: false,
        },
      ],

    socialLinks: [
      { icon: 'github', link: 'https://github.com/Koverae/koverae-billing' },
      {
        icon: {
          svg: '<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><title>telegram</title> <path d="M22.122 10.040c0.006-0 0.014-0 0.022-0 0.209 0 0.403 0.065 0.562 0.177l-0.003-0.002c0.116 0.101 0.194 0.243 0.213 0.403l0 0.003c0.020 0.122 0.031 0.262 0.031 0.405 0 0.065-0.002 0.129-0.007 0.193l0-0.009c-0.225 2.369-1.201 8.114-1.697 10.766-0.21 1.123-0.623 1.499-1.023 1.535-0.869 0.081-1.529-0.574-2.371-1.126-1.318-0.865-2.063-1.403-3.342-2.246-1.479-0.973-0.52-1.51 0.322-2.384 0.221-0.23 4.052-3.715 4.127-4.031 0.004-0.019 0.006-0.040 0.006-0.062 0-0.078-0.029-0.149-0.076-0.203l0 0c-0.052-0.034-0.117-0.053-0.185-0.053-0.045 0-0.088 0.009-0.128 0.024l0.002-0.001q-0.198 0.045-6.316 4.174c-0.445 0.351-1.007 0.573-1.619 0.599l-0.006 0c-0.867-0.105-1.654-0.298-2.401-0.573l0.074 0.024c-0.938-0.306-1.683-0.467-1.619-0.985q0.051-0.404 1.114-0.827 6.548-2.853 8.733-3.761c1.607-0.853 3.47-1.555 5.429-2.010l0.157-0.031zM15.93 1.025c-8.302 0.020-15.025 6.755-15.025 15.060 0 8.317 6.742 15.060 15.060 15.060s15.060-6.742 15.060-15.060c0-8.305-6.723-15.040-15.023-15.060h-0.002q-0.035-0-0.070 0z"></path></svg>'
        },
        link: 'https://t.me/koverae_billing',
        ariaLabel: 'Telegram Group'
      }
    ],

    footer: {
      message: 'Released under the <a href="https://github.com/Koverae/koverae-billing/blob/master/LICENSE">MIT License</a>.',
      copyright: 'Copyright © 2025 <a href="https://github.com/arden28">Arden BOUET</a>'
    }
  },
})
