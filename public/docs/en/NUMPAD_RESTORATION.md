# Clock-in Pad Improvements (V1.2.0)

In this update, we have performed a deep review of the **Clock-in Pad (Numpad)** to recover the essence and performance of its most stable versions.

## 🔄 Restoration of Classic Design
We have returned to the visual structure of commit `c23964fa8`, recognized for its clarity and ease of use. This includes:
- **High Contrast Buttons**: Improves visibility in bright environments.
- **Smooth Transitions**: 0.7-second visual effects for a more pleasant tactile response.
- **Centered Clock**: Better visual alignment of the current time relative to the keypad.

## 📱 Mobile Device Optimization
At our users' request, we have vertically "compacted" the keypad:
- **Lower Height**: Margins and internal padding have been reduced so the keypad takes up less screen space, allowing more information to be seen without scrolling.
- **Simplified Branding**: The logo and title are now more discreet to prioritize interaction.

## 🌍 Full Localization
The Clock-in Pad is now fully bilingual:
- The **Insert code**, **Reset**, and **Delete** buttons now automatically switch between Spanish and English according to user preference.
- Accessibility labels (`aria-labels`) have been improved for screen readers.

## 🛠️ Technical Stabilization
CSS code has been consolidated, removing aggressive compilation dependencies that caused random display errors. This ensures the keypad looks **perfect** on all browsers and devices on every load.

## 📱 New Mobile App & API Security
As part of this 1.2.0 release, we haven't just improved the web, but also the mobile ecosystem:
- **APK Distribution**: The new version of the Android application is now available for direct download from this same documentation panel.
- **REST Security**: We have reinforced the authentication endpoint by implementing mandatory expiration for Sanctum tokens, closing potential security gaps.
- **App Improvements**: Design bugs in the top bar (AppBar) that caused overlaps on certain phone models have been fixed, ensuring menus are always visible.

---
*© 2026 sientiaCTH - Evolving for you*
