from fastapi import FastAPI
from pydantic import BaseModel
from sklearn.linear_model import LogisticRegression
import numpy as np

app = FastAPI()

# Sample data for training Logistic Regression (positive, neutral, negative counts)
# Higher positive counts increase chance of being endorsed

sentiments = np.array([
    [80, 10, 10],  # positive
    [60, 20, 20],  # positive
    [30, 40, 30],  # neutral
    [20, 10, 70],  # negative
    [5, 10, 30],   # negative
    [90, 5, 5],    # positive
    [1, 1, 10],    # negative
    [10, 10, 15],  # negative
    [1, 10, 1],    # neutral
    [10, 1, 1],    # positive
    
    [70, 20, 10],  # positive
    [50, 30, 20],  # positive
    [25, 40, 35],  # neutral
    [15, 25, 60],  # negative
    [5, 5, 85],    # negative
    [85, 10, 5],   # positive
    [10, 5, 70],   # negative
    [8, 12, 25],   # negative
    [20, 30, 30],  # neutral
    [95, 2, 3],    # positive
])

endorsed = np.array([
    1, 1, 0, 0, 0, 1, 0, 0, 0, 1,
    1, 1, 0, 0, 0, 1, 0, 0, 0, 1
])


# Train Logistic Regression Model
log_reg_model = LogisticRegression()
log_reg_model.fit(sentiments, endorsed)

class SentimentRequest(BaseModel):
    positive: int
    neutral: int
    negative: int

@app.post("/predict-nps")
def predict_nps(request: SentimentRequest):
    data = np.array([[request.positive, request.neutral, request.negative]])
    prediction = log_reg_model.predict(data)
    return {"nps_result": "Endorsed" if prediction[0] == 1 else "Not Endorsed"}
