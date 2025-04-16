from google.oauth2.credentials import Credentials
from google_auth_oauthlib.flow import InstalledAppFlow
from google.auth.transport.requests import Request
import os

SCOPES = ['https://www.googleapis.com/auth/gmail.send']

def authenticate_google():
    creds = None
    if os.path.exists("token.json"):
        creds = Credentials.from_authorized_user_file("token.json", SCOPES)
    
    if not creds or not creds.valid:
        if creds and creds.expired and creds.refresh_token:
            creds.refresh(Request())
        else:
            flow = InstalledAppFlow.from_client_secrets_file(
                r"C:/xampp/htdocs/pbl2_sourcecode/spendly/email_with_python/credentials.json", SCOPES
            )
            creds = flow.run_local_server(port=8080)  # Use port 8080 for web app
        with open("token.json", "w") as token:
            token.write(creds.to_json())

authenticate_google()
print("Authentication successful! Token saved in 'token.json'.")
