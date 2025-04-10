from fastapi import FastAPI
from pydantic import BaseModel
from sklearn.linear_model import LogisticRegression
import numpy as np

app = FastAPI()


# Sample data for training Logistic Regression (Responses, CSAT Score, and whether it is Endorsed or Not)
# This data needs to reflect past training on responses and whether they were endorsed or not.
# 1: Endorsed, 0: Not Endorsed
responses = np.array([[100, 85], [200, 90], [150, 60], [300, 70], [250, 95], [50, 95], [50, 65]])  # Total Responses, CSAT Score
endorsed = np.array([1, 1, 0, 0, 1, 1, 0])  # 1 for Endorsed, 0 for Not Endorsed

# Train Logistic Regression Model
model = LogisticRegression()
model.fit(responses, endorsed)

class NPSRequest(BaseModel):
    total_responses: int
    csat_score: int

@app.post("/predict-nps")
def predict_nps(request: NPSRequest):
    # Prepare input data for prediction
    response_data = np.array([[request.total_responses, request.csat_score]])

    # Predict endorsement (1: Endorsed, 0: Not Endorsed)
    prediction = model.predict(response_data)

    # Based on the prediction, return whether it is endorsed or not
    if prediction[0] == 1:
        return {"nps_result": "Endorsed"}
    else:
        return {"nps_result": "Not Endorsed"}
