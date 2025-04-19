import json
import re
from google import genai  # Import the Google GenAI library

# Load Gemini API key from api-cred.json
def load_api_key():
    try:
        with open("api-cred.json", "r") as file:
            data = json.load(file)
            return data.get("api_key", "")
    except Exception as e:
        return None

def clean_and_format_response(text):
    # Replace markdown-style bold **text** with <b>text</b>
    text = re.sub(r'\*\*(.*?)\*\*', r'<b>\1</b>', text)

    # Replace bullet points (*) with bolded headings
    text = re.sub(r'\n\s*[\*\-]\s+', r'\n<b>• </b>', text)

    # Replace numbered points (1., 2., etc.) with bolded number + period
    text = re.sub(r'(?<=\n)(\d+)\.\s+', r'<b>\1. </b>', text)

    # Replace subpoints like * with plain dashes and indent if needed
    text = re.sub(r'\n\s*\*\s+', r'\n - ', text)

    # Convert line breaks for HTML
    text = text.replace('\n', '<br>')

    return "<div style='white-space: pre-wrap;'>" + text + "</div>"

def analyze_financial_goals(data):
    gemini_api_key = load_api_key()
    if not gemini_api_key:
        return "API key not found or invalid in api-cred.json"

    transactions = data.get('transactions', [])
    financial_profile = data.get('financial_profile', {})

    prompt = f"""
    Given the following financial transactions and profile, analyze whether the user met their financial goals, all amounts are in Indian Rupees (INR).:

    Transactions:
    {json.dumps(transactions, indent=2)}

    Financial Profile:
    {json.dumps(financial_profile, indent=2)}
    """

    try:
        # Use the GenAI client to interact with Gemini model
        client = genai.Client(api_key=gemini_api_key)

        # Send the prompt to the Gemini model and receive a response
        response = client.models.generate_content(
            model="gemini-2.0-flash",  # Ensure you're using the correct model name
            contents=prompt
        )

        # Extract and clean up the text
        text_response = response.text if response else "No response from model."
        formatted_response = clean_and_format_response(text_response)

        return formatted_response

    except Exception as e:
        return f"Exception during API call: {str(e)}"

if __name__ == '__main__':
    input_file_path = "data_for_python.json"  # Path to input file in AI Studio (can be adjusted)

    try:
        with open(input_file_path, 'r') as file:
            data = json.load(file)
    except Exception as e:
        print(json.dumps({"message": f"Error reading input file: {str(e)}"}))

    result = analyze_financial_goals(data)
    print(json.dumps({"message": result}))
