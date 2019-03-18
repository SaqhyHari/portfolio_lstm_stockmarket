import numpy as np
import matplotlib.pyplot as plt
import pandas as pd
import quandl
quandl.ApiConfig.api_key = 'EpVb5SE59swkaGuHM_yN'
f = open("predict_input.txt", "r")
comp=f.readline()
while comp!=None:
	trainingSet = quandl.get(comp, start_date="2014-12-31", end_date="2017-12-31")
	#trainingSet = pd.read_csv('/home/hari/Downloads/RNN-StockPricePrediction-master/Google_Stock_Price_Train.csv')
	trainingSet = trainingSet.iloc[:,1:2].values

	#Feature Scaling
	from sklearn.preprocessing import MinMaxScaler
	sc = MinMaxScaler()
	trainingSet = sc.fit_transform(trainingSet)

	#Getting input and output
	xTrain = trainingSet[0:len(trainingSet)-1]
	yTrain = trainingSet[1:len(trainingSet)+2]

	#Reshaping the inputs
	xTrain = np.reshape(xTrain, (len(trainingSet)-1, 1, 1 ))

	#Importing the packages
	from keras.models import Sequential
	from keras.layers import Dense
	from keras.layers import LSTM

	#Initializing the RNN
	model = Sequential()
	#this is a regression model because the output would be a real number and not 0 or 1
	#Adding the LSTM layer
	model.add(LSTM(units = 4, activation = 'sigmoid', input_shape=(None, 1)))
	#Adding the output layer
	#we'll keep most of the things as default
	#units corrospond to the no  of neurons in the output layer, here the output is 1D (units=1)
	model.add(Dense(units=1))
	#Compiling the RNN
	model.compile(optimizer='adam', loss = 'mean_squared_error')
	#Fitting the model
	model.fit(x =xTrain , y =yTrain , batch_size=8, epochs=300)
	model.save_weights('TrainedRNN.h5')

	#Test Set
	testSet = quandl.get(comp)
	#testSet = pd.read_csv('/home/hari/Downloads/RNN-StockPricePrediction-master/Google_Stock_Price_Test.csv')
	realStockPrice = testSet.iloc[:, 1:2].values
	inputs = realStockPrice
	inputs = sc.transform(inputs)
	inputs = np.reshape(inputs, (len(inputs),1,1))
	prediction = model.predict(inputs)

	#now the predicted output is scaled, we will apply the reverse transform method to get the actual predicted prices
	prediction = sc.inverse_transform(prediction)
	print("Predicted Close value is : %s",prediction[len(prediction)-1])
	#Visualization the results
	plt.plot(realStockPrice, color = 'black', label='RealPrice')
	plt.plot(prediction, color = 'red', label='Predicted')
	plt.xlabel('days')
	plt.ylabel('Price')
	plt.title('Predictied Output')
	plt.legend()
	plt.savefig(comp+".jpg")
	comp=f.readline()
f.close()