import base64
import os
import sys
import logging
import codecs
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from email.mime.image import MIMEImage
from google.oauth2.credentials import Credentials
from googleapiclient.discovery import build
from google.auth.exceptions import GoogleAuthError
from datetime import datetime 

# ✅ Enable Logging with UTF-8 encoding
logging.basicConfig(filename="email_error.log", level=logging.DEBUG, encoding="utf-8",
                    format="%(asctime)s - %(levelname)s - %(message)s")

SCOPES = ["https://www.googleapis.com/auth/gmail.send"]

def send_membership_welcome_email(email, first_name, membership_id):
    try:
        # Get the absolute path
        BASE_DIR = os.path.dirname(os.path.abspath(__file__))  
        TOKEN_PATH = os.path.join(BASE_DIR, "token.json")  

        if not os.path.exists(TOKEN_PATH):
            raise FileNotFoundError(f"ERROR: token.json not found at {TOKEN_PATH}")

        # Load credentials
        creds = Credentials.from_authorized_user_file(TOKEN_PATH)
        service = build("gmail", "v1", credentials=creds)

        message = MIMEMultipart()
        message["to"] = email
        message["subject"] = "Welcome to Spendly"
        message["from"] = "Founder's Office <do.not.reply.test.2023@gmail.com>"
        current_date = datetime.today().strftime("%B %d, %Y") 

        html_content = f"""
        <div style='font-family: Arial, sans-serif; padding: 20px;'>
                <div style='text-align: center;'>
                    <img src='cid:logoimg' alt='Spendly' style='width: 150px;'><br>
                    <p style='font-size: 12px; color: #888;'>{current_date}</p>
                </div>
                <hr style='border: 0; border-top: 1px solid #ddd; margin: 20px 0;'>
            
            <p>Dear {first_name},</p>
            
            <p>We are pleased to confirm that your membership with Spendly is now active. You now have access to a suite of exclusive financial tools and insights.</p>

            <p><strong>Membership ID:</strong> {membership_id}</p>

            <p><strong>Next Steps:</strong></p>
            <ul>
                <li>Log in to your account to explore your personalized dashboard.</li>
                <li>Set up your preferences for a customized experience.</li>
                <li>Contact our support team for any assistance.</li>
            </ul>

            <p>We appreciate your trust in Spendly and look forward to supporting your financial journey.</p>

            <p>Best regards,</p>
            <p><strong>Founder's Office</strong><br>Spendly Inc.</p>

            <hr style="border: 0; border-top: 1px solid #ccc; margin: 20px 0;">

            <p style="font-size: 12px; color: #666666;">
                This is an automated email – please do not reply. If you need assistance, contact  
                <a href="mailto:support@spendly.com" style="color: #004AAD; text-decoration: none;">support@spendly.com</a>.
            </p>

            <p style="font-size: 12px; color: #666666;">
                © {2025} Spendly Inc. | 
                <a href="#" style="color: #666666; text-decoration: none;">Privacy Policy</a> |  
                <a href="#" style="color: #666666; text-decoration: none;">Terms of Use</a>
            </p>
        </div>
        """
        message.attach(MIMEText(html_content, "html"))

        logo_path = os.path.join(os.getcwd(), "logo-no-background.png")
        if os.path.exists(logo_path):
            with open(logo_path, "rb") as img_file:
                img = MIMEImage(img_file.read(), _subtype="png")
                img.add_header("Content-ID", "<logoimg>")
                img.add_header("Content-Disposition", "inline", filename="logo-no-background.png")  # ✅ This helps Gmail display the image
                message.attach(img)
        else:
            logging.error(f"Logo image not found at {logo_path}")

        raw_message = base64.urlsafe_b64encode(message.as_bytes()).decode()
        service.users().messages().send(userId="me", body={"raw": raw_message}).execute()

        # ✅ Use UTF-8 encoding for printing
        sys.stdout = codecs.getwriter("utf-8")(sys.stdout.detach())
        print("✔ Email sent successfully to", email)

    except GoogleAuthError as e:
        logging.error(f"Google Auth Error: {e}")
        print("Authentication failed. Please re-authenticate.")
    except Exception as e:
        logging.error(f"Failed to send email: {e}")
        print("❌ Email sending failed. Check logs for details.")

if __name__ == "__main__":
    if len(sys.argv) != 4:
        print("Usage: python email_sender.py <recipient> <first_name> <membership_id>")
        sys.exit(1)

    recipient = sys.argv[1]
    first_name = sys.argv[2]
    membership_id = sys.argv[3]
    # recipient = "ishansurdi@gmail.com"
    # first_name = "Ishan"
    # membership_id = "1234567890"

    send_membership_welcome_email(recipient, first_name, membership_id)
