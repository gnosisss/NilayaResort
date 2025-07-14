# Midtrans Payment Gateway Integration

## Environment Variables

To complete the Midtrans integration, you need to add the following environment variables to your `.env` file:

```
MIDTRANS_CLIENT_KEY=your_client_key_here
MIDTRANS_SERVER_KEY=your_server_key_here
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

### Explanation of Environment Variables

- **MIDTRANS_CLIENT_KEY**: Your Midtrans client key (used for client-side integration)
- **MIDTRANS_SERVER_KEY**: Your Midtrans server key (used for server-side integration)
- **MIDTRANS_IS_PRODUCTION**: Set to `true` for production environment, `false` for sandbox/testing
- **MIDTRANS_IS_SANITIZED**: Set to `true` to enable request sanitization
- **MIDTRANS_IS_3DS**: Set to `true` to enable 3D Secure authentication

## Getting Your Midtrans Keys

1. Sign up for a Midtrans account at [https://dashboard.midtrans.com/register](https://dashboard.midtrans.com/register)
2. After registration and login, go to your Midtrans Dashboard
3. Navigate to Settings > Access Keys
4. You'll find both your Client Key and Server Key there
5. For testing, use the Sandbox keys
6. For production, use the Production keys (only when your integration is fully tested)

## Payment Configuration

### Payment Expiration Time

The payment expiration time is set to **5 minutes** for all Midtrans payment methods. This means customers must complete their payment within 5 minutes after initiating the transaction, or the payment session will expire.

## Testing the Integration

To test the Midtrans integration:

1. Set `MIDTRANS_IS_PRODUCTION=false` in your `.env` file
2. Use the Sandbox keys from your Midtrans Dashboard
3. Use the following test credit card details for sandbox testing:
   - Card Number: `4811 1111 1111 1114`
   - CVV: `123`
   - Expiry: Any future date
   - 3D Secure OTP: `112233`

## Webhook Configuration

To receive payment notifications from Midtrans:

1. Log in to your Midtrans Dashboard
2. Go to Settings > Configuration
3. Set your Payment Notification URL to: `https://your-domain.com/midtrans/notification`
4. Make sure your server is accessible from the internet

## Troubleshooting

### Common Issues

1. **Payment Not Processed**
   - Check your server logs for any errors
   - Verify that your Midtrans keys are correct
   - Ensure your webhook URL is properly configured

2. **CSRF Token Mismatch**
   - The Midtrans notification endpoint is already excluded from CSRF verification
   - If you're still experiencing issues, check that the `ValidateCsrfToken` middleware is properly configured

3. **Redirect Issues**
   - Ensure your routes are properly defined
   - Check that the finish, unfinish, and error URLs are correctly set in your Midtrans configuration

## Support

If you encounter any issues with the Midtrans integration, please refer to:

- [Midtrans Documentation](https://docs.midtrans.com/)
- [Midtrans API Reference](https://api-docs.midtrans.com/)
- [Midtrans Support](https://support.midtrans.com/)