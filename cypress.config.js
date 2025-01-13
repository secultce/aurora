const { defineConfig } = require("cypress");
require('dotenv').config();

module.exports = defineConfig({
  viewportWidth: 1920,
  viewportHeight: 1080,
  e2e: {
    baseUrl: process.env.CYPRESS_BASE_URL,
    chromeWebSecurity: false,
    setupNodeEvents(on, config) {
    },
    specPattern: [
      'cypress/e2e/api/**/*.cy.js',
      'cypress/e2e/web/agent/*.cy.js',
      'cypress/e2e/web/authentication/*.cy.js',
      'cypress/e2e/web/**/*.cy.js',
      'cypress/e2e/admin/dashboard/*.cy.js',
      'cypress/e2e/admin/**/*.cy.js',
    ],
  },
});
